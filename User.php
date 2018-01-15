<?php 

class User
{
	private $email;
	private $firstname;
	private $lastname;
	private $age;

	function __construct($email, $fname, $lname, $age)
	{
		$this->email = $email;
		$this->firstname = $fname;
		$this->lastname = $lname;
		$this->age = $age;
	}

	public function isValid()
	{
		return filter_var($this->email, FILTER_VALIDATE_EMAIL)
		&& !empty($this->firstname)
		&& !empty($this->lastname)
		&& is_int($this->age)
		&& $this->age >= 13;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setFirstname($fname)
	{
		$this->firstname = $fname;
	}

	public function setLastname($lname)
	{
		$this->lastname = $lname;
	}

	public function setAge($age)
	{
		$this->age = $age;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getFirstname()
	{
		return $this->firstname;
	}

	public function getLastname()
	{
		return $this->lastname;
	}

	public function getAge()
	{
		return $this->age;
	}

}

?>
