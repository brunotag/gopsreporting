<?php
    require_once __DIR__.'/DataTransform/model/chartRow.php';

    class exportToChartRowsVisitor{
        private $chartRows;

        public function __construct()
        {
            $this->chartRows = [];
        }

        public function visit($nodeSnapshot){
            $chartRowValues = $this->buildChartRow($nodeSnapshot->getValue());
            $chartRowOffset = $nodeSnapshot->getLevel();
            $newChartRow = new chartRow($chartRowValues, $chartRowOffset);
            array_push($this->chartRows, $newChartRow);
        }

        public function getChartRows(){
            return $this->chartRows;
        }

        private function buildChartRow($nodeValue){
            $chartRowValues = array();
            if(gettype($nodeValue) == 'object' && get_class($nodeValue) == 'keyValue'){
                array_push($chartRowValues, $nodeValue->key);
                if(gettype($nodeValue->value) == 'object' && get_class($nodeValue->value) == 'byMemberCategory'){
                    array_push($chartRowValues, $nodeValue->value->clubTwins);
                    array_push($chartRowValues, $nodeValue->value->clubSingles);
                    array_push($chartRowValues, $nodeValue->value->privateOwners);
                }
                else{
                    array_push($chartRowValues, $nodeValue->value);
                }
            }else{
                array_push($chartRowValues, $nodeValue);
            }
            return $chartRowValues;
        }
    }
?>