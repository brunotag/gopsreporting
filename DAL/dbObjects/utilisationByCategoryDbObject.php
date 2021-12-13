<?php
    require_once 'dbObject.php';
    require_once './DAL/Types/byMemberCategory.php';

    class utilisationByCategoryDbObject extends dbObject{
        public $hours;      //byMemberCategory
        public $launches;   //byMemberCategory

        public function __construct($db){
            parent::__construct($db);
        }

        protected function getSql(){
            return <<<'SQL'
            SELECT  CASE
                        WHEN FIND_IN_SET(TRIM(glider),'GPJ,GGR,GNP,GFY,GFN')  > 0 THEN 'club_twin' 
                        WHEN FIND_IN_SET(TRIM(glider),'GNB,GMB') > 0 THEN 'club_singles' 
                        ELSE 'private_owners' 
                    END as category_of_customer,
                    count(*) as launches,
                    ROUND(SUM(land - start) / 3600000) as hours
            FROM gliding.flights
            WHERE localdate >= ? AND localdate < ? AND org = 1 AND start > 0
            GROUP BY category_of_customer
            ORDER by category_of_customer;
SQL;
        }

        protected function buildReturnValue($buildReturnValue){
            switch ($buildReturnValue["category_of_customer"]) {
                case "club_singles":
                    $this->launches->clubSingles = (int)$buildReturnValue["launches"];
                    $this->hours->clubSingles = (float)$buildReturnValue["hours"];
                    break;
                case "club_twin":
                    $this->launches->clubTwins = (int)$buildReturnValue["launches"];
                    $this->hours->clubTwins = (float)$buildReturnValue["hours"];
                    break;
                case "private_owners":
                    $this->launches->privateOwners = (int)$buildReturnValue["launches"];
                    $this->hours->privateOwners = (float)$buildReturnValue["hours"];
                    break;
              }
        }

        protected function reset(){
            $this->hours = new byMemberCategory();
            $this->launches = new byMemberCategory();
        }
    }
?>