<?php

namespace Abstraction;

class ContactForm
{
	public $name;
	public $email;
	public $address;
	public $phone;
	public $acquisition_method;
	public $budget;


	public function __construct($data = null)
	{
		if (is_array($data)) {
			if (isset($data['id'])) $this->id = $data['id'];
			$this->name = $data['name'];
			$this->email = $data['email'];
			$this->address = $data['address'];
			$this->phone = $data['phone'];
			$this->acquisition_method = $data['acquisition_method'];
			$this->budget = $data['budget'];
		}
	}

	public function SaveData()
	{
		//Could be used for saving depending on SoC architecture.
	}

	public function GetData()
	{
		//Could be used for a select or custom/elaborate return.
	}
}