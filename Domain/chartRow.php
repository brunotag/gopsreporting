<?php
    class chartRow{
        //array of primitive types
        private $values;

        //0+
        private $offset;

        public function __construct($values, $offset)
        {
            $this->values = $values;
            $this->offset = $offset;
        }

        public function getValues(){
            return $this->values;
        }

        public function getOffset(){
            return $this->offset;
        }
    }
?>