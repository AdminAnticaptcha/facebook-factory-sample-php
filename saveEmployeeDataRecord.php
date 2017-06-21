<?php

    include("api.php");
    include("dumbdb.php");

    $api        =   new Api();
    $dumpDb     =   new DumpDB();
        
    $recordId   =   $api->getInputInt("recordId");
    $data       =   $api->getInput("data");
    
    $name       =   $data["forms"][1]["value"];
    $gender     =   $data["forms"][2]["value"];
    $language   =   $data["forms"][3]["value"];

    $dumpDb->setDBFile("accounts.txt");
    $dumpDb->insertOrUpdateRecord($recordId, array(
        "name"      =>  $name,
        "gender"    =>  $gender,
        "language"  =>  $language
    ));

    $api->success();