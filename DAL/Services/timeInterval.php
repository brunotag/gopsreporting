<?php
    class timeInterval{
        public $startDateInclusive;
        public $endDateExclusive;

        public function __construct($startDateInclusive, $endDateExclusive)
        {
            $this->startDateInclusive = $startDateInclusive;
            $this->endDateExclusive = $endDateExclusive;
        }
    }
?>