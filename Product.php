<?php

require 'User.php';

class Product
{
	
	private $name;
	private $status;
	private $owner;

	function __construct($name, $status, $user)
	{
		$this->name = $name;
		$this->status = $status;
		$this->owner = $user;
	}

	public function isValid()
	{
		return !empty($this->name)
		&& isset($this->owner)
		&& $this->owner->isValid();
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setOwner($user)
	{
		$this->owner = $user;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getOwner()
	{
		return $this->owner;
	}

}

?>
