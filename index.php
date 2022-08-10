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

ray($containers);
ray($transports);

$data = array();

foreach($transports as $key => $transport){

    foreach($containers as $key2 => $container){
//        $track = 1;
//        if()
        $multiplier = $transport->totalLoad/$container->capacity;
//        ray()
        $data[$key][$key2] = [
            "transaport" => $transport->name,
            "containers" => $multiplier,
            "freeSpace" => intval(($multiplier * $container->capacity))
        ];

    }
}
ray($data);

