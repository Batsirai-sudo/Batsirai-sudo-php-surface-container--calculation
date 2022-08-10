<?php


namespace Batsirai\PhpContainerSurfaceCalculation;


use Batsirai\PhpContainerSurfaceCalculation\Interfaces\CalculationInterface;
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

    public function getResults($containers,$transports){
        $data = array();

        foreach($transports as $key => $transport){

            foreach($containers as $key2 => $container){

                $data[$key][$key2] = $this->fillContainer($container,$transport);
                $data[$key][$key2]['transport'] = $transport->name;

            }
        }

        return $this->detemineContainer($data);
    }
    public function detemineContainer($data){

        foreach($data as $key => $item){
            $object = array_reduce($item, function($a, $b){
                return $a['freespace'] < $b['freespace']  ? $a : $b;
            }, array_shift($item));

            if($object['freespace'] > 0){
                $object['containers']++;
                unset($object['freespace']);
            }
            $data[$key] = $object;
        }
        return ($data);
    }

    public function fillContainer($container,$transport){
        $count = 1;
        while ($container->capacity){
            $result = $transport->totalLoad - ($container->capacity * $count);
            if($result < 0){
                // Remaining space in the container
                $result = abs($result);
                break;
            }else{
                $count ++;
            }
        }
        return [
            "containers" => $count,
            "freespace" => $result,
            "name" => $container->type
        ];
    }

}
