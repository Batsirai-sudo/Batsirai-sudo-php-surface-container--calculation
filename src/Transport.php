<?php


namespace Batsirai\PhpContainerSurfaceCalculation;


class Transport
{
    public  string $name;
    public  array $load;
    /**
     * @var Calculation
     */
    private Calculation $calculation;
    public int $totalLoad;

    public function __construct($data){

        $this->name = $data['name'];
        for ($i = 0; $i < count($data['data']); ++$i) {
            $this->load[$i] = new ObjectClass($data['data'][$i]);
        }
        $this->calculation = new Calculation();
        $this->totalLoad = $this->totalLoad();
    }

    public function totalLoad():int{
        return (array_reduce( $this->load, function ($sum, $entry) {
            $sum += $entry->area;
            return $sum;
        }, 0));
    }

}
