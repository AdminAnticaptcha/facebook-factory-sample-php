<?php

    include("api.php");
        
    $api        =   new Api();

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
