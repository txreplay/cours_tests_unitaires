<?php

require '../User.php';

class UserTest extends PHPUnit_Framework_TestCase
{

	/**
	* @covers User::isValid
	*/
	public function testIsValidNominal()
	{
		$user = new User("test@test.fr", "toto", "toto", 20);
		$result = $user->isValid();
		$this->assertTrue($result);
	}

	/**
	* @covers User::isValid
	*/
	public function testIsNotValidBecauseEmailFormat()
	{
		$user = new User("test.fr", "toto", "toto", 20);
		$result = $user->isValid();
		$this->assertFalse($result);
	}	

	/**
	* @covers User::isValid
	*/
	public function testIsNotValidBecauseFirstnameIsInvalid()
	{
		$user = new User("test@test.fr", "", "toto", 20);
		$result = $user->isValid();
		$this->assertFalse($result);
	}

	/**
	* @covers User::isValid
	*/
	public function testIsNotValidBecauseToYoung()
	{
		$user = new User("test@test.fr", "toto", "toto", 11);
		$result = $user->isValid();
		$this->assertFalse($result);
	}

}

?>