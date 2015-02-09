<?php
/*
@date: 2/2/15
@author: Alvaro Home <xzero7>

@purpose: Create sql statments per DB table
*/


include_once('connectDB.php');
include_once('responseCodes.php');

/*
	db-is the DB object to handle mysqli calls
*/
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
	@purpose- will generate an api key for user created using md5
	@params 
	@return
		string - api string for user  

*/ 
private function generateApiKey() 
{
    return md5(uniqid(rand(), true));
}

/*
	@purpose- will create a new user in DB
	@params
		-email       - the email for new user
		-password    - password for new user 
		-firstName   - first name of new user
		-lastName    - last name of new user
	@return
		-success  - response code for success
		-fail     - response code for failure
*/
public function createUser($email, $password, $firstName, $lastName)
{

}

?>
