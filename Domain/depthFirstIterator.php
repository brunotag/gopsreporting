<?php
    require_once 'nodeSnapshot.php';
    class depthFirstIterator
    {
        private $nodeSnapshots;
        private $index;

        public function getNext(){
            $retval = $this->nodeSnapshots[$this->index];
            $this->index++;
            return $retval;
        }

        public function hasMore(){
            return $this->index < count($this->nodeSnapshots);
        }

        public function __construct($root, $minLevel, $resetLevelToZero)
        {
            $this->nodeSnapshots = $this->buildIterator($root, $minLevel, $resetLevelToZero, 0);
            $this->index = 0;
        }

        private function buildIterator($node, $minLevel, $resetLevelToZero, $level)
        {
            $nodeSnapshots = [];
            if($level >= $minLevel){
                array_push($nodeSnapshots, new nodeSnapshot(
                    $node->getValue(),
                    $resetLevelToZero ? $level - $minLevel : $level
                ));
            }

            foreach ($node->getChildren() as $child) {
                $nodeSnapshots = \array_merge(
                    $nodeSnapshots,
                    $this->buildIterator($child, $minLevel, $resetLevelToZero, $level + 1)
                );
            }

            return $nodeSnapshots;
        }
    }
?>