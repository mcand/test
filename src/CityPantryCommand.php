<?php 

namespace CityPantry;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

use CityPantry\VendorFileParser;
use CityPantry\MenuFinder;

class CityPantryCommand extends Command{
	protected function configure(){
		$this->setName("findmenus")
			->setDescription("Search for menu items available in a given a file, day, location and number of covers")
			->addArgument('input', InputArgument::REQUIRED, 'File containg the vendors and items in the correct form')
			->addArgument('day', InputArgument::REQUIRED, 'Delivery day (dd/mm/yy)')
			->addArgument('time', InputArgument::REQUIRED, 'Delivery time in 24h format (hh:mm)')
			->addArgument('location', InputArgument::REQUIRED, 'Delivery location (postcode without spaces, e.g. NW43QB)')
			->addArgument('covers', InputArgument::REQUIRED, 'Number of people to feed');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$location = $input->getArgument('location');
		$covers = $input->getArgument('covers');
		$day = $input->getArgument('day');
		$time = $input->getArgument('time');
		$parser = new VendorFileParser($input->getArgument('input'));
		$parser->parse();
		$vendors = (array) $parser->getVendors();
		$menu = new MenuFinder($vendors, $location, $covers, $day, $time);
		echo "The Following Items Can Be Delivered:\n\n";
		$output->writeln($menu->findMenu());
 	}
}