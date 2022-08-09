<?php


namespace Batsirai\PhpContainerSurfaceCalculation;


use ObjectInterface;

class ObjectClass extends Calculation implements ObjectInterface {

    public int $area;

    public function __construct($data){
        foreach ($data as $key => $obj) {
            $this->{$key} = $obj;
        }
      $this->area = $this->area();
    }

    public function area() {
       return $this->objectArea();
    }

}
