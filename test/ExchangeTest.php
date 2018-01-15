<?php

require '../Exchange.php';

class ExchangeTest extends PHPUnit_Framework_TestCase
{

	private $exchange;

	/**
	* @covers Exchange::save
	*/
	public function testExchangeCreationNominal()
	{
		$result = $this->exchange->save();
		$this->assertTrue($result);
	}

	/**
	* @covers Exchange::save
	* @expectedException Exception
	* @expectedExceptionMessage Exchange creation failed because begin date must not be in the past
	*/
	public function testExchangeCreationFailedBeginInThePast()
	{
		
		$begin = new DateTime();
		$begin->modify('-1 day');
		$end = new DateTime();
		$end->modify('+1 day');

		$this->exchange->setBegin($begin);
		$this->exchange->setEnd($end);

		$this->exchange->save();
	}

	/**
	* @covers Exchange::save
	* @expectedException Exception
	* @expectedExceptionMessage Exchange creation failed because begin date must be before end date
	*/
	public function testExchangeCreationFailedEndBeforeBegin()
	{
		
		$begin = new DateTime();
		$begin->modify('+2 day');
		$end = new DateTime();
		$end->modify('+1 day');

		$this->exchange->setBegin($begin);
		$this->exchange->setEnd($end);

		$this->exchange->save();
	}

	/**
	* @covers Exchange::save
	* @expectedException Exception
	* @expectedExceptionMessage Exchange creation failed because the receiver is not active
	*/
	public function testExchangeCreationFailedUserIsNotValid()
	{
		$mockedUserNotValid = $this->getMock('User', array('isValid'), array(null, null, null, null));
		$mockedUserNotValid->expects($this->any())->method('isValid')->will($this->returnValue(false));
		$this->exchange->setReceiver($mockedUserNotValid);

		$this->exchange->save();
	}

	/**
	* @covers Exchange::save
	*/
	public function testExchangeCreationWithYoungUser()
	{
		$mockedDatabase = $this->getMock('DatabaseConnection', array('saveExchange'));
		$mockedDatabase->expects($this->any())->method('saveExchange')->will($this->returnValue(true));
		$this->exchange->setDatabaseConnection($mockedDatabase);

		$mockedEmailSender = $this->getMock('EmailSender', array('sendEmail'));
		$mockedEmailSender->expects($this->once())->method('sendEmail');
		$this->exchange->setEmailSender($mockedEmailSender);

		$result = $this->exchange->save();
		$this->assertFalse($result);
	}

	protected function setUp()
	{
		$begin = new DateTime();
		$begin->modify('+1 day');
		$end = new DateTime();
		$end->modify('+2 day');

		// Mock User
		$mockedUser = $this->getMock('User', array('isValid'), array(null, null, null, null));
		$mockedUser->expects($this->any())->method('isValid')->will($this->returnValue(true));

		// Mock Product
		$mockedProduct = $this->getMock('Product', array('isValid', 'getOwner'), array(null, null, null));
		$mockedProduct->expects($this->any())->method('isValid')->will($this->returnValue(true));
		$mockedProduct->expects($this->any())->method('getOwner')->will($this->returnValue($mockedUser));

		// Mock Database connection
		$mockedDBConn = $this->getMock('DatabaseConnection', array('saveExchange'));
		$mockedDBConn->expects($this->any())->method('saveExchange')->will($this->returnValue(false));

		// Mock Email sender
		$mockedEmailSender = $this->getMock('EmailSender', array('sendEmail'));
		$mockedEmailSender->expects($this->never())->method('sendEmail');

		$this->exchange = new Exchange($mockedUser,$mockedProduct, $begin, $end, $mockedDBConn, $mockedEmailSender);
	}

	protected function tearDown()
	{
		$this->exchange = NULL;
	}

}

?>