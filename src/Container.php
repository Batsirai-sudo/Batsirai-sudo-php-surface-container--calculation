<?php


namespace Batsirai\PhpContainerSurfaceCalculation;


//class Container
//{
//    private $width, $length, $type;
//    public static $instance;
//
//    public static function getInstance(){
//        if(!isset(Container::$instance))
//            Container::$instance = new Container();
//        return Container::$instance;
//    }
//
//    private function __construct($width,$length,$type){
//        $this->width = $width;
//        $this->length = $length;
//        $this->type = $type;
//    }
//
////    public function containerSurface()
////    {
////        return (int) $this->width * (int) $this->length;
////    }
//
//    public function getContainerCapacity($length, $width){
//        return (new Calculation('QUADRILATERAL'))->containerCapacity($length, $width);
//    }
//
//
//}

class Container{

    protected int $length;
    protected int $width;
    protected string $type;
    public int $capacity;
    /**
     * @var Calculation
     */
    private Calculation $calculation;

    public function __construct($data){
        $this->width = $data['width'];
        $this->length = $data['length'];
        $this->type = $data['type'];

        $this->calculation = new Calculation();
        $this->capacity = $this->getCapacity();
    }

    public function getCapacity(): int{
        return $this->calculation->containerCapacity([
            $this->width,
            $this->length
        ]);
    }

}
