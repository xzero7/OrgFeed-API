<?php
/*
@date: 2/2/15
@author: Alvaro Home <xzero7>

@purpose: Class that will handle encrypting passwords
			Will be using sha1 encryption
*/

class encryption
{
	private static $algo = '$2a';
	private static $cost = '$10';

	/*
	@purpose- create a unique salt
	@params - none
	@return
		-string - the new salt created
	*/
	private static function uniqueSalt()
	{
		return substr(sha1(mt_rand()),0,22);
	}
	/*
		@purpose- will hash a given password
		@params
			-password - password to be hashed
		@return
			-string - hashed version of the password
	*/
	public static function hash($password)
	{
		return crypt($password, self::$algo.self::$cost.'$'.self::uniqueSalt());
	}

	/*
	@purpose- check if password entered matches stored one
	@params
		-hash        - current stored hash
		-password    - password that was entered
	@return
		-true  - if passwords match
		-false - passwords don't match
	*/
	public function checkPassword($hash, $password)
	{
		$fullSalt = substr($hash,0,29);
		$newHash = crypt($password,$fullSalt);
		return ($hash == $newHash);
	}

}

?>
