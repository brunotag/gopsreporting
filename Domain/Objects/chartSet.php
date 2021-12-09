<?php
    class chartSet{
        //chartDimension
        public $flyingDays;

        //chartDimension
        public $flyingHours;

        //chartDimension
        public $launches;

        public function __construct($flyingDays, $flyingHours, $launches){
            $this->flyingDays = $flyingDays;
            $this->flyingHours = $flyingHours;
            $this->launches = $launches;
        }
    }
?>