<?php

    include("api.php");
    include("dumbdb.php");

    $api        =   new Api();
    $dumbDb     =   new DumpDB();
    $dumbDb->setDBFile("accounts.txt");
        
    $recordId   =   $api->getInputInt("recordId");
    $dataRow    =   $dumbDb->getRecordById($recordId);

    if ($recordId == 0 or !$dataRow) {
        //using empty variables
        $name       =   "";
        $gender     =   "";
        $language   =   "";
    } else {
        //loading data from text file
        $name       =   $dataRow["name"];
        $gender     =   (int)$dataRow["gender"];
        $language   =   $dataRow["language"];
    }
    
    $form       =   array(
        "createButtonText"  =>  $recordId == 0 ? "Add account" : "Edit account",
        "formTitle"         =>  "Edit your data",
        "formSubtitle"      =>  "Add the data you want",
        "forms"             =>  array(
            array(
                "label"         =>  "",
                "labelHint"     =>  false,
                "contentType"   =>  "image",
                "content"       =>  "https://files.anti-captcha.com/e47/dc741d72.png",
                "inputType"     =>  false
            ),
            array(
                "label"         =>  "Your name",
                "labelHint"     =>  "Please enter your Facebook name",
                "contentType"   =>  false,
                "inputType"     =>  "text",
                "name"          =>  "name",
                "value"         =>  $name
            ),
            array(
                "label"         =>  "Your gender",
                "labelHint"     =>  "Please select your gender",
                "contentType"   =>  false,
                "inputType"     =>  "radio",
                "name"          =>  "gender",
                "value"         =>  $gender,
                "inputOptions"  =>  array(
                    array("value" =>  0,  "caption" =>  "Female"),
                    array("value" =>  1,  "caption" =>  "Male"),
                )
            ),
            array(
                "label"         =>  "Your language",
                "labelHint"     =>  "Select your primary language",
                "contentType"   =>  false,
                "inputType"     =>  "select",
                "name"          =>  "language",
                "value"         =>  $language,
                "inputOptions"  =>  array(
                    array("value" =>  -1,  "caption" =>  "Select..."),
                    array("value" =>  "en",  "caption" =>  "English"),
                    array("value" =>  "es",  "caption" =>  "Spanish"),
                    array("value" =>  "de",  "caption" =>  "German"),
                    array("value" =>  "ru",  "caption" =>  "Russian"),
                    array("value" =>  "ua",  "caption" =>  "Ukrainian")
                )
            ),
            array(
                "label"         =>  "Authorize",
                "labelHint"     =>  "Click on the link to authorize",
                "contentType"   =>  "link",
                "contentOptions"=>  array(
                    "url"   =>  "http://my-facebook-factory-url.com/authorize?employee=$recordId",
                    "text"  =>  "Authorize Facebook account # $recordId"
                ),
                "inputType"     =>  false
            ),
        )
    );
        
    $api->apiResponse($form);