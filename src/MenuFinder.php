<?php
namespace CityPantry;

use \Datetime;

class MenuFinder{
	public $vendors = array();
	public $location;
	public $date;
	public $time;
	public $covers;

	function __construct($vendors, $location, $covers, $day, $time){
		$this->vendors = $vendors;
		$this->location = $location;
		$this->covers = $covers;
		$this->day = $day;
		$this->time = $time;
	}

	function findMenu(){
		$vendorsInLocation = $this->findVendorsInLocation();
		$vendorsThatServeCover = $this->findVendorsThatServeCover($vendorsInLocation);
		$itemsAvailable = $this->itemsThatServeOnTime($vendorsThatServeCover);
		$this->printItems($itemsAvailable);
	}

	private function findVendorsInLocation(){
		$vendorsInLocation = array();
		$vendors = (array) $this->vendors;
		for($i = 0; $i < count($vendors); $i++){
			if(substr($this->vendors[$i]->location, 0, 3) === substr($this->location, 0, 3)){
				array_push($vendorsInLocation, $this->vendors[$i]);
			}
		}
		return $vendorsInLocation;
	}

	private function findVendorsThatServeCover($vendorsInLocation){
		$vendorsThatServeCover = array();
		for($i = 0; $i < count($vendorsInLocation); $i++){
			if((intval($vendorsInLocation[$i]->covers)) >= intval(($this->covers))){
				array_push($vendorsThatServeCover, $vendorsInLocation[$i]);
			}
		}
		return $vendorsThatServeCover;		
	}

	private function hoursBetweenRequestedTimeAndCurrentTime(){
		$currentTime = new DateTime();
		$searchTime = DateTime::createFromFormat('d/m/y H:i', "{$this->day} {$this->time}");
		$diff = $currentTime->diff($searchTime);
		$hours = $diff->h + ($diff->days * 24);
		return $hours;
	}

	private function itemsThatServeOnTime($vendors){
		$itemsThatCanBeDelivered = array();
		$totalHours = $this->hoursBetweenRequestedTimeAndCurrentTime();
		// loop through vendors
		foreach($vendors as $v){
			$items = $v->itemsAvailable;
			foreach($items as $item){
				$advanceTime = substr($item->advanceTime, 0, -1);
				if($advanceTime >= $totalHours){
					array_push($itemsThatCanBeDelivered, $item);
				}
			}
		}
		return $itemsThatCanBeDelivered;
	}

	private function printItems($items){
		foreach($items as $item){
			echo($item->name . ';' . $item->allergies . "\n");
		}
	}
}