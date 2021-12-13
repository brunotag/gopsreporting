<?php
    class month{
        public $name;

        public function __construct($monthInt){
            switch($monthInt){
                case 7:
                    $this->name="July";
                break;
                case 8:
                    $this->name="August";
                break;
                case 9:
                    $this->name="September";
                break;
                case 10:
                    $this->name="October";
                break;
                case 11:
                    $this->name="November";
                break;
                case 12:
                    $this->name="December";
                break;
                case 1:
                    $this->name="January";
                break;
                case 2:
                    $this->name="February";
                break;
                case 3:
                    $this->name="March";
                break;
                case 4:
                    $this->name="April";
                break;
                case 5:
                    $this->name="May";
                break;
                case 6:
                    $this->name="June";
                break;
            }
        }
    }
?>