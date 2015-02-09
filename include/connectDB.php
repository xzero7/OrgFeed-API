<?php
/*
@date: 10/20/14
@author: Alvaro Home <xzero7>

@purpose: A simple class to maniuplate mysqli calls
*/

class Database
{
	private $result;
	private $host = "127.0.0.1"; // change to your own default values
	private $user = "root"; // change to your own default values
	private $password = "MYSECRET"; // change to your own default values
	private $db = "OrgFeed";
	private $mysqli;
	
	/*
		destroys this class and disconnects from server
	*/
	public function __destruct()
	{
		$this->disconnect();
	}

	
	/*
		given a user, password, host and database, this function 
		setup will and connect to that server
		@param user
		@param pass
		@param host
		@param db
	*/
	public function setup($user, $pass, $host, $db)
	{
		$this->user = $user;
		$this->password = $pass;
		$this->host = $host;
		$this->db = $db;
		
		if(isset($this->mysqli))
			$this->disconnect();
		
		$this->connect();
	}
	
	/*
		will change the designated database to a new one
		@param db
	*/
	public function pickDB($db)
	{
		$this->db = $db;
		
		if(isset($this->mysqli))
			$this->mysqli->select_db($db);
		else
			$this->connect();
	}
	
	/*
		will connect to server based on saved credentials
	*/
	public function connect()
	{
		if(isset($this->mysqli))
			$this->disconnect();

		try 
		{
			if(!$this->mysqli= new mysqli($this->host, $this->user, $this->password, $this->db))
				throw new Exception("Cannot Connect to ".$this->host);
		} catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}
	}

	/*
		will disconnect from server
	*/	
	public function disconnect()
	{
		if(isset($this->mysqli))
			$this->mysqli->close();
		if(isset($this->result) && gettype($this->result) == "object")
		{
			$this->result->free();
		}
		
		unset($this->result);
		unset($this->mysqli);
	}
	
	/*
		will take a sql statement and attempt to execute it
		@param sql
	*/
	public function sendSQL($sql)
	{
		$response = array();
		if(!isset($this->mysqli))
			$this->connect();
		
		try 
		{
			if(isset($this->result) && gettype($this->result) == "object")
				$this->result->free();
			if(!$this->result = $this->mysqli->query($sql))
				throw new Exception("Could not send query");
		} catch (Exception $e)
		{
			$response['pass'] = false;
			$response['message'] = $e->getMessage();
			$response['error'] = $this->mysqli->error;

			return $response;
		}
		$response['pass'] = true;
		$response['data'] = $this->result;
		return $response;
	}
	
	/*
		will return an array the contains the result of the next row
		will return false if operation fails		
	*/
	public function nextRow()
	{
		if(isset($this->result))
			return $this->result->fetch_assoc();
		
		//if code gets here there was no query executed before
		echo "You have not executed a query, cannot fetch next row.";
		return false;
	}
	
	/*
		will create a new database and will select it as the main database
		@param name
	*/
	public function newDB($name)
	{
		if (!isset($this->mysqli))
			$this->connect();
		
		$query = "CREATE DATABASE IF NOT EXISTS ".$name;
		
		try 
		{
			if (!$this->mysqli->query($query))
				throw new Exception("Cannot create database ".$name);
			
			$this->db = $name;
			$this->mysqli->select_db($name);
		} catch (Exception $e)
		{
			echo $e->getMessage()."<BR>";
			echo mysql_error();
			exit;
		}	
	}
	
	/*
		the following function will printout everything in result
		in a formatted table. this will be mainly used for testing queries
	*/
	public function printResults()
	{
		if (isset($this->result) && (($this->result->num_rows) > 0))
		{
			$this->result->data_seek(0);
			$names = $this->result->fetch_fields();
			$num = count($names);
			
			echo "<table border=1>";
			echo "<tr>";
			
			for ($i=0;$i<$num;$i++)
			{
			   echo "<th>";
			   echo $names[$i]->name;
			   echo "</th>";
			}
			
			echo "</tr>";
			
			while ($row  =  $this->result->fetch_row()) 
			{
				echo "<tr>";
				foreach ($row as $elem) 
				{
				   echo "<td>$elem</td>";
				}
				echo "</tr>";
			}
			
			echo "</table>";
			$this->result->data_seek(0);
		}
		else
			echo "There is nothing to print!<BR>";
	}
	

	

}


?>
