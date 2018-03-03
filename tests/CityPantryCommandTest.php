<?php

use CityPantry\CityPantryCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

require_once  './vendor/autoload.php'; 

class CityPantryCommandTest extends PHPUnit\Framework\TestCase{
    public function testHashIsCorrect(){
        $filePath = system(pwd) . '/file_examples/input';
        $application = new Application();
        $application->add(new CityPantryCommand());

        $command = $application->find('findmenus');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName(),
            'input'        => $filePath,
            'day'          => '13/03/18',
            'time'         => '04:50',
            'location'     => 'SW34DA',
            'covers'       => '10'
        ));    

        $this->assertRegExp('//', $commandTester->getDisplay());
    }

}
