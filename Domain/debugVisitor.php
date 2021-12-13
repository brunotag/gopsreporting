<?php
    class debugVisitor{
        public function visit($nodeSnapshot){
            for($i=1;$i<$nodeSnapshot->getLevel();$i++){
                echo ("\t");
            }
            $value = $nodeSnapshot->getValue();
            if(gettype($value) == 'object' && get_class($value) == 'keyValue'){
                $this->printValue($value->key);
                echo (' | ');
                if(gettype($value->value) == 'object' && get_class($value->value) == 'byMemberCategory'){
                    $this->printValue($value->value->clubTwins);
                    echo (' | ');
                    $this->printValue($value->value->clubSingles);
                    echo (' | ');
                    $this->printValue($value->value->privateOwners);
                }
                else{
                    $this->printValue($value->value);
                }
            }else{
                $this->printValue($value);
            }
            echo ("\r\n");
        }

        private function printValue($value)
        {
            if (is_null($value))
            {
                echo ("<NULL>");
            }
            else{
                echo($value);
            }
        }
    }
?>