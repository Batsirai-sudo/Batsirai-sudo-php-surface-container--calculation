<?php

define('ROOT',dirname(__FILE__).DIRECTORY_SEPARATOR);
define('OBJECT_KEYS',['square','circle']);
define('CONTAINERS','Containers');
define('TRANSPORT','Transport');
define('SHAPE_FORMULAS',[
    "square" => 'width * length',
    "circle" => 'radius * radius * 4',
]);

require_once ROOT.'vendor/autoload.php';

use Batsirai\PhpContainerSurfaceCalculation\ProcessFile;

$processFile = ProcessFile::getInstance('inputs.txt');

$containers = $processFile->generate(CONTAINERS);
$transports = $processFile->generate(TRANSPORT);

rsort($containers);


$freeEmptySpaceArray = array();

foreach($transports as $key=> $transport){

    foreach($containers as $container){
        $track = 1;
        ray($container->capacity/$transport->totalLoad);

    }
}

