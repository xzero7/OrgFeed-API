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

	private static function unique_salt()
	{
		return substr(sha1(mt_rand()),0,22);
	}

	public static function hash($password)
	{
		return crypt($password, self::$algo.self::$cost.'$'.self::unique_salt());
	}

}

?>
