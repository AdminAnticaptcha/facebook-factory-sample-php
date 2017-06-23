<?php

    include("api.php");
    include("dumbdb.php");
        
    $api        =   new Api();
    $dumpDb     =   new DumpDB();
    //getting input parameters
    $taskId =   $api->getInputInt("taskId");
    $url    =   $api->getInput("url");
    $action =   $api->getInput("action");


    $dumpDb->setDBFile("tasks.txt");

    //inserting task record
    $dumpDb->insertOrUpdateRecord($taskId, array(
        "url"       =>  $url,
        "action"    =>  $action,
        "status"    =>  "new"
    ));
    
    
    $api->apiResponse(array());
