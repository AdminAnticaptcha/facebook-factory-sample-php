<?php

    include("api.php");
    include("dumbdb.php");

    $api        =   new Api();
    $dumpDb     =   new DumpDB();
        
    $recordId   =   $api->getInputInt("recordId");

    $dumpDb->setDBFile("accounts.txt");
    $dumpDb->removeRecord($recordId);

    $api->success();