<?php


namespace Batsirai\PhpContainerSurfaceCalculation;


use Batsirai\PhpContainerSurfaceCalculation\src\Interfaces\CalculationInterface;
use Batsirai\PhpContainerSurfaceCalculation\Traits\Formulas;

class Calculation implements CalculationInterface {

    use Formulas;

    public function containerCapacity($data): int{
        return $this->multiply($data[0],$data[1]);
    }

    public function objectArea(){

        if(isset(SHAPE_FORMULAS[$this->type])){
            $obj = SHAPE_FORMULAS[$this->type];

            foreach(explode(' ',$obj) as $item){
                if(property_exists($this,$item)){
                    $obj =  str_replace($item,$this->{$item},$obj);
                }
            }
            return $this->execute($obj);
        }
        throw new \InvalidArgumentException('No formula found for '.$this->type.'  for transport '.$this->width );
    }


}
