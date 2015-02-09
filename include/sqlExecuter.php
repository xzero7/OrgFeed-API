<?php
/*
@date: 2/2/15
@author: Alvaro Home <xzero7>

@purpose: Create sql statments per DB table
*/


include_once('connectDB.php');


private $db;

function __construct()
{
	$db = new Database();
	$db->connect();
}

/*
	@purpose- will check if suggested user exist by verifying email
	@params
		-email - the email being checked
		-db    - the db instance class to execute sql
	@return
		-true  - if user already exists
		-false - user does not exist
*/
private function userExists($email)
{
	$query = "Select * FROM Users Where email='".$email."'";

	//run query
	$result = $db->sendSQL($query);
	$row = $db->nextRow();

	if($row == null)
	{
		return false;
	} 
	else
	{
		return true;
	}
}

/*
	@purpose- will check if suggested user exist by verifying email
	@params
		-email - the email being checked
		-db    - the db instance class to execute sql
	@return
		-true  - if user already exists
		-false - user does not exist
*/
public function createUser($email, $password, $firstName, $lastName)
{

}

?>
