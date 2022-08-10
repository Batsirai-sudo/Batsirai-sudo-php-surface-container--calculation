<?php

namespace Batsirai\PhpContainerSurfaceCalculation\Traits;


trait Formulas
{
    private array $operators = [
        ['symbol' => '+', 'func' => 'add'],
        ['symbol' => '-', 'func' => 'subtract'],
        ['symbol' => '/', 'func' => 'divide'],
        ['symbol' => '*', 'func' => 'multiply']
    ];

    public function add($data){
        return array_sum($data);
    }
    public function subtract($minuend,$subtrahend){
        return $minuend - $subtrahend;
    }
    public function divide($dividend,$divisor){
        return $dividend / $divisor;
    }
    public function multiply($multiplier,$multiplicand){
        return $multiplier * $multiplicand;
    }

    public function execute($values){

        $tempArray = array();
        $currentOperator = '';
        $sum = 0;
        foreach(explode(' ',$values) as $item){

            if(is_numeric($item)){
                $tempArray[] = $item;

                if(count($tempArray) === 2){
                  $result  =  array_filter($this->operators, function($k) use ($currentOperator) {
                            return $k['symbol'] === $currentOperator;  });

                   $operator = [...$result][0];

                   $sum = $this->{$operator['func']}( (float) $tempArray[0] ,(float)$tempArray[1]);

                    $currentOperator = '';

                    $tempArray  = array($sum);

                }
            }else{
                $currentOperator = $item;
            }

        }

        return $sum;
    }
}
