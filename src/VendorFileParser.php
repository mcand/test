<?php
namespace CityPantry;

use CityPantry\Vendor;
use CityPantry\Item;

class VendorFileParser {
	public $filePath;
	public $vendors = array();

	function __construct($path){
		$this->filePath = $path;
	}

	public function isValidFile(){
		$file = fopen($this->filePath, "r");
		$aux=0;
		$prev_was_white_line=false;
		while(($line = fgets($file)) != false){
			if($aux == 0 && count(explode(';', $line)) != 3){
				return false;
			}

			if($aux != 0 && strlen(trim($line)) == 0){
				$prev_was_white_line = true;
				continue;
			}

			if($prev_was_white_line == true && count(explode(';', $line)) != 3){
				return false;		
			}
			++$aux;
		}
		return true;
	}

	public function parse(){
		$file = fopen($this->filePath, "r");
		$is_vendor = true; // initially we are looking for vendors
		$currentVendor; 
		if($file){
			while(($line = fgets($file)) != false){
				// we are looking for vendor on the next line, so we skip
				if (strlen(trim($line)) == 0){
					$is_vendor = true;
					continue;
				}
				// vendor data
				if($is_vendor == true){
					$vendor =	explode(';', $line)[0];
					$location =	explode(';', $line)[1];
					$cover =	explode(';', $line)[2];
					$currentVendor = new Vendor($vendor, $location, $cover);
					array_push($this->vendors, $currentVendor);
					$is_vendor = false;
				} else {
					// it's an item
					$name = explode(';', $line)[0];
					$allergies = explode(';', $line)[1];
					$time = explode(';', $line)[2];
					$item = new Item($name, $allergies, $time);
					$currentVendor->addItemToVendor($item);
				}
			}
			fclose($file);
		}else{
			die("Error while loading the file.");
		}
	}

	public function getVendors(){
		return $this->vendors;
	}
}