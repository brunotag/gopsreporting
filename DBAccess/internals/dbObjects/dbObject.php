<?php
    abstract class dbObject{
        private $db;

        public function __construct($db)
        {
            $this->db = $db;
        }

        public function hydrateFromDb($timeInterval){
            $this->reset();

            $sql = $this->getSql();
        
            $statement = $this->db->prepare($sql);
            $statement->bind_param("dd", $timeInterval->startDateInclusive, $timeInterval->endDateExclusive);
            $statement->execute();
            $meta = $statement->result_metadata();
            $row = array();
            while ($field = $meta->fetch_field())
            {
                $byref_array_for_fields[] = &$row[$field->name];
            }
        
            call_user_func_array(array($statement, 'bind_result'), $byref_array_for_fields);
        
            while ($statement->fetch()) {
                foreach($row as $key => $val)
                {
                    $c[$key] = $val;
                }
                $this->buildReturnValue($c);
            }
            $statement->free_result();
            $statement->close();
        }

        abstract protected function getSql();

        abstract protected function buildReturnValue($buildReturnValue);

        abstract protected function reset();
    }
?>