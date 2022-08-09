<?php


namespace Batsirai\PhpContainerSurfaceCalculation;


class ProcessFile{

    public static ProcessFile $instance;
    private string $file;
    private array $containers;
    private array $objects;

    public static function getInstance($file) {
        if (!isset(ProcessFile::$instance))
            ProcessFile::$instance = new ProcessFile($file);
        return ProcessFile::$instance;
    }

    private function __construct($file) {
        $this->file = $file;
        $this->filterContents();
    }

    public function filterContents(){
        $newFile = 'newFile.txt';

        file_put_contents($newFile,
            preg_replace(
                '~[\r\n]+~',
                "\r\n",
                trim(file_get_contents($this->file))
            )
        );
        $txt_file = fopen($newFile, 'r');

        while ($line = fgets($txt_file)) {
            if(str_contains($line, 'container')){
                $this->containers[] = $line;
            }else{
                if($line !== ''){
                    $this->objects[] = $line;
                }
            }
        }
        fclose($txt_file);

        unlink($newFile);
    }

    public function processContainers(){
        $newContainers = array();

        foreach($this->containers as $key => $container){
            $newContainers[$key] = $this->destructureString($container);
        }

        return $newContainers;
    }

    public function processTransport(){
        $newObjects = array();
        $obj = $this->objects;
        $index = -1;
        $objIndex = 0;
        for ($i = 0; $i < count($obj); ++$i) {
            if(str_contains($obj[$i], 'Transport')){
                $index++;
                $objIndex = 0;
                $newObjects[$index]['name'] = $obj[$i];
            }else{
                $newObjects[$index]['data'][$objIndex] = $this->destructureString($obj[$i]);
                $objIndex++;
            }
        }
        return $newObjects;
    }

    public function destructureString($data){
        $newArray = array();
        $type = strtok($data, ':');

        $strArray = explode(" ", str_replace($type.':','',$data));
        unset($strArray[0]);

        for ($i = 1; $i < count($strArray)+1; ++$i) {
            if($i % 2 == 0 || $i === 0){
                $newArray[$strArray[$i-1]] = (int) $strArray[$i];
                $newArray['type'] = $type;
            }
        }

        return $newArray;
    }

    public function generate($type){
        $obj = array();
        $process = 'process'.$type;

        foreach($this->{$process}() as $data){
            switch($type){
                case CONTAINERS:
                    $obj[] = new Container($data);
                    break;
                case TRANSPORT:
                    $obj[] = new Transport($data);
                    break;
            }
        }
        return $obj;

    }

}
