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
                $taskSubtitle   =   "Proceed to the link and press like at this Facebook page";
                break;
            
            case "repost";
                $taskTitle      =   "Make repost";
                $taskSubtitle   =   "Proceed to the link and repost the link";
                break;
            
            case "comment";
                $taskTitle      =   "Comment a post";
                $taskSubtitle   =   "Proceed to the link and comment Facebook post";
                break;
        }
        
        $result = array();
        $result["action"]       =   "showForm";
        $result["time"]         =   60;
        $result["formTitle"]    =   $taskTitle;
        $result["formSubtitle"] =   $taskSubtitle;
        $result["forms"]        =   array(
            
            array(
                "label"             =>  "Link",
                "labelHint"         =>  false,
                "contentType"       =>  "link",
                "content"           =>  array(
                    "url"   =>  $record["url"],
                    "text"  =>  "Go to post"
                ),
                "inputType"         =>  false
            ),
            array(
                "label"         =>  "Screenshot confirmation",
                "labelHint"     =>  "Confirm your job by pasting screenshot\n( Press 'Printscreen' on your keyboard on Facebook, and CTR+V here )",
                "contentType"   =>  false,
                "name"          =>  "confirmation",
                "inputType"     =>  "imageUpload"
            ),
            
        );
        
        $api->apiResponse($result);
        
    }
        
    
    