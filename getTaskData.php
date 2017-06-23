<?php

    include("api.php");
    include("dumbdb.php");
        
    $api        =   new Api();
    $dumpDb     =   new DumpDB();

    $dumpDb->setDBFile("tasks.txt");
        
    $taskIds    =   $api->getInput("taskIds");
    $records    =   array();

    foreach ($taskIds as $taskId) {
        $row = $dumpDb->getRecordById($taskId);
        if ($row != false) {
            $records[] = $row;
        }
    }
        
        
    $api->apiResponse(array(
        "data" => $records
    ));
     