<?php

    include("api.php");
    include("dumbdb.php");

    $api        =   new Api();
    $dumbDb     =   new DumpDB();
    $dumbDb->setDBFile("accounts.txt");

    $records    =   decodeStoredData($dumbDb->getAllRecords());
    
    $data       =   array();

    foreach ($records as $row) {
        
        $data[] =   array(
            array(
                "contentType"   =>  "image",
                "content"       =>  "https://files.anti-captcha.com/e47/dc741d72.png"
            ),
            array(
                "contentType"   =>  "text",
                "content"       =>  $row["name"]
            ),
            array(
                "contentType"   =>  "text",
                "content"       =>  $row["gender"]
            ),
            array(
                "contentType"   =>  "text",
                "content"       =>  $row["language"]
            ),
            array(
                "contentType"   =>  "buttons",
                "content"       =>  "edit,remove",
                "recordId"      =>  $row["id"]
            )
        );
        
    }

    $api->apiResponse(array(
        "header"    =>  array(
            "",
            "Alias Name",
            "Gender",
            "Language",
            "Edit"
        ),
        "data"      =>  $data
    ));

    function decodeStoredData($data) {
        $genders    =   array(
            "0"     =>  "Female",
            "1"     =>  "Male"
        );
        $languages  =   array(
            "en"    =>  "English",
            "es"    =>  "Spanish",
            "de"    =>  "German",
            "ru"    =>  "Russian",
            "ua"    =>  "Ukrainian"
        );
        foreach ($data as &$row) {
            $row["gender"]      =   $genders[$row["gender"]];
            $row["language"]    =   $languages[$row["language"]];
        }
        return $data;
    }