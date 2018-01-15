<?php

require '../User.php';

class UserTest extends PHPUnit_Framework_TestCase
{

	private $user;

	/**
	* @covers User::isValid
	*/
	public function testisValidNominal()
	{
		$result = $this->user->isValid();
		$this->assertTrue($result);
	}

	/**
	* @covers User::isValid
	*/
	public function testIsNotActiveBecauseEmailFormat()
	{
		$this->user->setEmail("test.fr");
		$result = $this->user->isValid();
		$this->assertFalse($result);
	}	

	/**
	* @covers User::isValid
	*/
	public function testIsNotActiveBecauseFirstnameIsInvalid()
	{
		$this->user->setFirstname("");
		$result = $this->user->isValid();
		$this->assertFalse($result);
	}

	/**
	* @covers User::isValid
	*/
	public function testIsNotActiveBecauseToYoung()
	{
		$this->user->setAge(9);
		$result = $this->user->isValid();
		$this->assertFalse($result);
	}

	protected function setUp()
	{
		$this->user = new User("test@test.fr", "toto", "toto", 20);
	}
	
	protected function tearDown()
	{
		$this->user = NULL;
	}

}

?>