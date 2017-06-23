<?php

    include("api.php");
    include("dumbdb.php");
        
    $api        =   new Api();
    $dumpDb     =   new DumpDB();

    $dumpDb->setDBFile("tasks.txt");
        
    $taskId     =   $api->getInputInt("taskId");

    $record     =   $dumpDb->getRecordById($taskId);
    if ($record == false) {
        $status =   "error"; //not found
    } else {
        $status =   $record["status"];
    }
        
    $result =   array(
        "status"    =>  $status
    );
        
    $api->apiResponse($result);
       