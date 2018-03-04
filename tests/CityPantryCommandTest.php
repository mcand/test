<?php

use CityPantry\CityPantryCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

require_once  './vendor/autoload.php'; 

class CityPantryCommandTest extends PHPUnit\Framework\TestCase{
    public function testSuccessfulFindMenu(){

        // example file on project
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
        $this->assertRegExp('/The Classic;gluten/', $commandTester->getDisplay());
    }
    public function testWithUnavailableLocation(){
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
            'location'     => 'HAHA34',
            'covers'       => '10'
        ));    
        $this->assertRegExp('//', $commandTester->getDisplay());
    }
    public function testWithGreaterCover(){
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
            'covers'       => '90'
        ));    
        $this->assertRegExp('//', $commandTester->getDisplay());
    }
    public function testWithNoTimeAvailable(){
        $filePath = system(pwd) . '/file_examples/input';
        $application = new Application();
        $application->add(new CityPantryCommand());
        $now = new DateTime();
        $month = $now->format('m');
        $year = $now->format('y');
        $day = $now->format('d');
        $hour = $now->format('H');
        $minute = $now->format('i');
        $command = $application->find('findmenus');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName(),
            'input'        => $filePath,
            'day'          => "{$day}/{$month}/{$year}",
            'time'         => "{$hour}:{$minute}",
            'location'     => 'SW34DA',
            'covers'       => '10'
        ));    
        $this->assertRegExp('//', $commandTester->getDisplay());
    }
    public function testWithInvalidFile(){
        $filePath = system(pwd) . '/file_examples/invalid_input';
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
        $this->assertRegExp('/The Classic;gluten/', $commandTester->getDisplay());
    }
}
