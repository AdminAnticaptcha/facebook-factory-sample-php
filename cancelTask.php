<?php


    include("api.php");

    $api        =   new Api();

    $taskId =   $api->getInputInt("taskId");
    $reason =   $api->getInput("reason");
        
        
        
    $api->apiResponse(array(
        "action"    =>  "restartTask"
    ));
        
    
