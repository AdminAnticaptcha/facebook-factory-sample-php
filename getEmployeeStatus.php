<?php

    include("api.php");
    include("dumbdb.php");
        
    $api        =   new Api();
    $dumpDb     =   new DumpDB();

    $dumpDb->setDBFile("employees.txt");

    $employee   =   $api->getInput("employee");

    $dumpDb->insertOrUpdateRecord($employee["id"], $employee);

    $api->apiResponse(array(
        /*
         * statuses :
         * allow         : allow to work immediately
         * train         : employee must pass exam/training
         * onApprove     : employee is on manual approval
         * banned        : no access
         * factoryIsFull : don't allow new employees to get in
         * */
        "status"  =>  "allow"
    ));
