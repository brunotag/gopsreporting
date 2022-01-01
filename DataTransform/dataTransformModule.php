<?php
    require_once __DIR__.'/DataTransform/internals/monthToTimeIntervalService.php';
    require_once __DIR__.'/DataTransform/internals/tree/treeBuilder.php';
    require_once __DIR__.'/DataTransform/internals/tree/depthFirstIterator.php';
    require_once __DIR__.'/DataTransform/internals/tree/exportToChartRowsVisitor.php';

    class dataTransformModule{
        private $dataService;

        public function __construct($dataService)
        {
            $this->dataService = $dataService;
        }

        public function getChartRows($month, $year){
            $timeIntervalService = new monthToIntervalService();
            $treeBuilder = new treeBuilder($this->dataService, $timeIntervalService);
            
            $tree = $treeBuilder->getChartTree($month, $year);
            
            $iterator = new depthFirstIterator($tree, 1, true); //minLevel 1 to skip root, resetLevelToZero so offset is 0
            $visitor = new exportToChartRowsVisitor();
            while($iterator->hasMore())
            {
                $visitor->visit($iterator->getNext());
            }
            
            $chartRows = $visitor->getChartRows();
            return $chartRows;
        }
    }
?>