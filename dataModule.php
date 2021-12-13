<?php
    require './DAL/db.php';
    require './DAL/dbObjects/utilisationByCategoryDbObject.php';
    require './DAL/dbObjects/totalsDbObject.php';
    require './DAL/Services/monthToTimeInterval.php';
    require './Domain/treeBuilder.php';
    require './DAL/dataService.php';

    class DataModule{
        public static function getChartTree($month, $year){
            ($string = file_get_contents('./config.json')) || die("can't find config file");;
            ($json_a = json_decode($string)) || die("can't decode configuration");
            $db = new db($json_a->SQL->host,$json_a->SQL->username,$json_a->SQL->gnocchi,$json_a->SQL->db);
            
            $totalsDbObject = new totalsDbObject($db);
            $utilisationDbObject = new utilisationByCategoryDbObject($db);
            $dataService = new dataService($totalsDbObject,$utilisationDbObject);
        
            $timeIntervalService = new monthToTimeInterval();
        
            $treeBuilder = new treeBuilder($dataService, $timeIntervalService);
        
            return $treeBuilder->getChartTree($month, $year);
        }
    }
?>