<?php

    include("api.php");
    include("dumbdb.php");
        
    $api        =   new Api();
    $dumpDb     =   new DumpDB();

    $dumpDb->setDBFile("tasks.txt");
        
    $taskId     =   $api->getInputInt("taskId");
    $data       =   $api->getInput("data");

    $record     =   $dumpDb->getRecordById($taskId);
    if ($record == false) {
        $api->apiResponse(array(), 47);
        exit;
    } else {
        
        if (isset($data["forms"])) {
            $screnshotUrl = $data["forms"][1]["value"];
            $record["confirmation"] =   $screnshotUrl;
            $record["status"]       =   "complete";
    
            $dumpDb->insertOrUpdateRecord($taskId, $record);
        }
        
    }
        
    $api->apiResponse(array(
        "action"    =>  "finishTask"
    ));