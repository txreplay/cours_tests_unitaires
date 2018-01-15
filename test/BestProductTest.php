<?php

require '../Product.php';

class ProductTest extends PHPUnit_Framework_TestCase
{

	private $product;

	/**
	* @covers Product::isValid
	*/
	public function testIsValidNominal()
	{
		$result = $this->product->isValid();
		$this->assertTrue($result);
	}

	/**
	* @covers Product::isValid
	*/
	public function testIsNotValidWrongStatus()
	{
		$this->product->setStatus(ProductStatus::DEACTIVATED());
		$result = $this->product->isValid();
		$this->assertFalse($result);
	}

	/**
	* @covers Product::isValid
	*/
	public function testIsNotValidOwnerIsNotValid()
	{
		$mockedOwnerNotValid = $this->getMock('User', array('isValid'), array(null, null, null, null));
		$mockedOwnerNotValid->expects($this->any())->method('isValid')->will($this->returnValue(false));

		$this->product->setOwner($mockedOwnerNotValid);
		$result = $this->product->isValid();
		$this->assertFalse($result);
	}

	protected function setUp()
	{
		$mockedOwner = $this->getMock('User', array('isValid'), array(null, null, null, null));
		$mockedOwner->expects($this->any())->method('isValid')->will($this->returnValue(true));

		$this->product = new Product("mon objet", ProductStatus::ACTIVATED(), $mockedOwner);
	}
	
	protected function tearDown()
	{
		$this->product = NULL;
	}

}

?>