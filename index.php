<?php

define('ROOT',dirname(__FILE__).DIRECTORY_SEPARATOR);
define('OBJECT_KEYS',['square','circle']);
define('CONTAINERS','Containers');
define('TRANSPORT','Transport');
define('SHAPE_FORMULAS',[
    "square" => 'width * length',
    "conatiner" => 'width * length',
    "circle" => 'radius * radius * 3.14',
]);

require_once ROOT.'vendor/autoload.php';

use Batsirai\PhpContainerSurfaceCalculation\Calculation;
use Batsirai\PhpContainerSurfaceCalculation\ProcessFile;

$processFile = ProcessFile::getInstance('inputs.txt');

$containers = $processFile->generate(CONTAINERS);
$transports = $processFile->generate(TRANSPORT);

$calculation = new Calculation();

var_dump($calculation->getResults($containers,$transports));



