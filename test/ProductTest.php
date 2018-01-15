<?php

require '../Product.php';

class ProductTest extends PHPUnit_Framework_TestCase
{

	private $owner;

	/**
	* @covers Product::isValid
	*/
	public function testisValidNominal()
	{
		$product = new Product("mon objet", ProductStatus::ACTIVATED(), $this->owner);
		$result = $product->isValid();
		$this->assertTrue($result);
	}

	/**
	* @covers Product::isValid
	*/
	public function testIsNotActiveWrongStatus()
	{
		$product = new Product("mon objet", ProductStatus::DEACTIVATED(), $this->owner);
		$result = $product->isValid();
		$this->assertFalse($result);
	}

	/**
	* @covers Product::isValid
	*/
	public function testIsNotActiveOwnerIsNotActive()
	{
		$this->owner->setAge(9);
		$product = new Product("mon objet", ProductStatus::ACTIVATED(), $this->owner);
		$result = $product->isValid();
		$this->assertFalse($result);
	}

	protected function setUp()
	{
		$this->owner = new User("test@test.fr", "toto", "toto", 20);
	}
	
	protected function tearDown()
	{
		$this->owner = NULL;
	}

}

?>