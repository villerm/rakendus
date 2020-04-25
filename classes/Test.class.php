<?php 
class Test {
    //properties
    private $secretNum = 3;
    public $number = 9;
    function __construct() {
        echo $this->secretNum;
        echo $this->number;
        $this->reveal();
    }
    function __destruct() {
        echo 'Class lõpetab';
    }
    public function reveal(){
        echo "Salajane number on: " . $this->secretNum;
    }
}