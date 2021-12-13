<?php 
    class nodeSnapshot{
        private $value;
        private $level;

        public function __construct($value, $level){
            $this->value = $value;
            $this->level = $level;
        }

        public function getValue(){
            return $this->value;
        }

        public function getLevel(){
            return $this->level;
        }

        public function accept($visitor)
        {
            return $visitor->visit($this);
        }
    }
?>