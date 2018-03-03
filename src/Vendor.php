<?php
namespace CityPantry;

class Vendor{
	public $name;
	public $location;
	public $covers;
	public $itemsAvailable = array();

	function __construct($name, $location, $covers){
		$this->name = $name;
		$this->location = $location;
		$this->covers = $covers;
	}

	public function addItemToVendor($item){
		array_push($this->itemsAvailable, $item);
	}
}