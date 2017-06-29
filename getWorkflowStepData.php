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
        $result["time"]         =   300;
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
            
            /*
            
            //Uncomment lines below to play with custom forms and content
            
            array(
                "label"         =>  "Image example",
                "labelHint"     =>  "This row displays image. You can click on the image to zoom it.",
                "contentType"   =>  "image",
                "content"       =>  "https://files.anti-captcha.com/654/795daca8.gif",
                "inputType"     =>  false
            ),
            
            
            array(
                "label"         =>  "Textarea",
                "labelHint"     =>  "Simple textarea",
                "contentType"   =>  false,
                "name"          =>  "text1",
                "inputType"     =>  "textarea",
                "inputOptions"  =>  array(
                    "width"         =>      100,
                    "rows"          =>      5,
                    "placeHolder"   =>      "custom placeholders supported"
                )
            ),
            
            array(
                "label"         =>  "Text input",
                "labelHint"     =>  "Text input with existing value",
                "contentType"   =>  false,
                "name"          =>  "text2",
                "inputType"     =>  "text",
                "value"         =>  "example value",
                "inputOptions"  =>  array(
                    "width"         =>      50
                )
            ),
            
            array(
                "label"         =>  "Long text",
                "labelHint"     =>  "Some multi-line text which nobody reads :(",
                "contentType"   =>  "text",
                "content"       =>  "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sed lectus ante. Nulla tortor ipsum, blandit in felis eu, sollicitudin ultrices massa. Nam egestas tellus a ligula hendrerit pretium. In a posuere erat. Sed sit amet lorem neque. Donec sem lacus, maximus tempus orci a, feugiat aliquam nulla. Suspendisse non lorem et nunc aliquet dapibus.

Curabitur quis nunc non nunc tempor placerat non iaculis leo. Duis laoreet massa non neque consequat vehicula. Mauris gravida luctus commodo. Nam sit amet placerat est. In et cursus tellus, ac feugiat magna. Aliquam dictum nunc id dui varius, quis pharetra nulla eleifend. Proin ut quam metus. Quisque vitae nulla nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis auctor elementum risus sit amet aliquam. Ut et dolor at enim congue varius. Maecenas sit amet felis felis."
            ),
            
            array(
                "label"         =>  "Radio button",
                "labelHint"     =>  "Options are provided by inputOptions",
                "contentType"   =>  false,
                "name"          =>  "opt",
                "inputType"     =>  "radio",
                "inputOptions"  =>  array(
                    array("value" =>  "opt1", "caption"   =>  "1st option"),
                    array("value" =>  "opt2", "caption"   =>  "2nd option"),
                    array("value" =>  "opt3", "caption"   =>  "3rd option"),
                )
            ),
            
            array(
                "label"         =>  "Select box",
                "labelHint"     =>  "Select box with preselected value \"2nd option\"",
                "contentType"   =>  false,
                "name"          =>  "select",
                "inputType"     =>  "select",
                "value"         =>  "opt2",
                "inputOptions"  =>  array(
                    array("value" =>  "opt1", "caption"   =>  "1st option"),
                    array("value" =>  "opt2", "caption"   =>  "2nd option"),
                    array("value" =>  "opt3", "caption"   =>  "3rd option"),
                )
            ),
            
            array(
                "label"         =>  "Checkbox",
                "labelHint"     =>  "Checkbox with labels",
                "contentType"   =>  false,
                "name"          =>  "box",
                "inputType"     =>  "checkbox",
                "inputOptions"  =>  array(
                    "label"         =>      "Check here if you are bored"
                )
            ),
            
            array(
                "label"         =>  "Checked Checkbox",
                "labelHint"     =>  "Checkbox with labels",
                "contentType"   =>  false,
                "name"          =>  "box",
                "inputType"     =>  "checkbox",
                "value"         =>  true,   //this thing checks it
                "inputOptions"  =>  array(
                    "label"         =>      "Somebody checked it already"
                )
            ),
            
            */
            
            
        );
        
        $api->apiResponse($result);
        
    }
        
    
    