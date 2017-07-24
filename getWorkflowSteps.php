<?php

    include("api.php");
    include("dumbdb.php");
        
    $api        =   new Api();
    $dumpDb     =   new DumpDB();

    $dumpDb->setDBFile("tasks.txt");
        
    $taskId     =   $api->getInputInt("taskId");

    $record     =   $dumpDb->getRecordById($taskId);
    if ($record == false) {
        $api->apiResponse(array(), 47);
        exit;
    } else {
        
        $taskTitle      =   "";
        $taskSubtitle   =   "";
        switch ($record["action"]) {
            
            case "like";
                $taskTitle      =   "Like a post";
                break;
            
            case "repost";
                $taskTitle      =   "Make repost";
                break;
            
            case "comment";
                $taskTitle      =   "Comment a post";
                break;
        }
        
    }
    
    $result     =   array(
        "jobTitle"          =>  "Facebookee",
        "steps"             =>  array(
            array(
                "id"        =>  123,
                "side"      =>  "employee",
                "title"     =>  $taskTitle
            )
        ),
        "startFromStep"     =>  0
        
    );

    $api->apiResponse($result);