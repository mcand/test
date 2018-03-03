<?php
namespace CityPantry;

class Item{
	public $name;
	public $allergies;
	public $advanceTime;

	function __construct($name, $allergies, $advanceTime){
		$this->name = $name;
		$this->allergies = $allergies;
		$this->advanceTime = $advanceTime;
	}

}