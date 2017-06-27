<?php

    include("dumbdb.php");
        
    $dumpDb     =   new DumpDB();

    $dumpDb->setDBFile("employees.txt");
    $employees  =   $dumpDb->getAllRecords();

    $dumpDb->setDBFile("tasks.txt");
    $tasks      =   $dumpDb->getAllRecords();


    runCommands($employees, $tasks);

    $apikey     =   file_get_contents("apikey.txt");
    $factoryCode=   file_get_contents("factorycode.txt");
    $secretKey  =   file_get_contents("secretkey.txt");



    $template   =   file_get_contents("manage.html");

    $settingRows=   array();

    if ($apikey == "") $settingRows[] = "<font color=red>Empty key!</font>";
    $settingRows[]  =   "<form method=post action=manage.php>
        <input type='hidden' name='action' value='saveApiKey'>
        API key: <input type='text' name='apiKey' size='50' value='$apikey' placeholder='client api key 32 bytes'>
        <input type='submit' value='save'></form>";

    if ($factoryCode == "") $settingRows[] = "<font color=red>Empty factory code!</font>";
    $settingRows[]  =   "<form method=post action=manage.php>
        <input type='hidden' name='action' value='saveFactoryCode'>
        Factory Code: <input type='text' name='factoryCode' size='50' value='$factoryCode' placeholder='SomeFactoryTask'>
        <input type='submit' value='save'></form>";

    if ($secretKey == "") $settingRows[] = "<font color=red>Empty secret key!</font>";
    $settingRows[]  =   "<form method=post action=manage.php>
        <input type='hidden' name='action' value='saveSecretKey'>
        Secret key: <input type='text' name='secretKey' size='50' value='$secretKey' placeholder='long secret key here'>
        <input type='submit' value='save'></form>";

    $template   =   str_replace("%settings%", implode("<br>", $settingRows), $template);

    //listing tasks
    $tasksRows  =   array("<table border='1' width='90%'><tr>
            <td>task ID</td>
            <td>URL</td>
            <td>action</td>
            <td>status</td>
            <td>assign to employee</td>
        </tr>");

    foreach ($tasks as $task) {
        
        //assign task button
        $assignButton   =   "<form method=post action=manage.php>
        <input type='hidden' name='action' value='assignTaskToEmployee'>
        <input type='hidden' name='taskId' value='$task[id]'>
        <select name='employeeId'>";
        foreach ($employees as $employee) {
            $assignButton   .=  "<option value='$employee[id]'>$employee[id] from $employee[country]</option>";
        }
        $assignButton   .=  "</select>
        <input type='submit' value='call assignTaskToEmployee'>
        </form>";
        
        //adding task html row
        $tasksRows[] = "
            <tr>
                <td>$task[id]</td>
                <td>$task[url]</td>
                <td>$task[action]</td>
                <td>$task[status]</td>
                <td>$assignButton</td>
            </tr>
        ";
    }
    $tasksRows[]    =   "</table>";

    //putting tasks into template
    $template       =   str_replace("%tasks%", implode("\n", $tasksRows), $template);

    //listing employees
    $employeeRows   =   array("<table border='1' width='90%'><tr>
            <td>ID</td>
            <td>IP, Country, City</td>
            <td>languages</td>
            <td>age</td>
            <td>gender</td>
        </tr>");

    foreach ($employees as $employee) {
        $employeeRows[] =  "<tr>
            <td>$employee[id]</td>
            <td>$employee[ip]<br>$employee[country], $employee[city]</td>
            <td>".implode(", ",$employee["languages"])."</td>
            <td>$employee[age]</td>
            <td>$employee[gender]</td>
        </tr>";
    }
    
    $employeeRows[] = "</table>";

    //putting employees into template
    $template       =   str_replace("%employees%", implode("\n", $employeeRows), $template);




    echo $template;


    function runCommands(&$employees, &$tasks) {
        
        global $_REQUEST;
        $action = @$_REQUEST["action"];
        
        $jsonResult =   "";
        
        switch ($action) {
            
            case "saveApiKey";
                file_put_contents("apikey.txt", $_REQUEST["apiKey"]);
                break;
            
            case "saveFactoryCode";
                file_put_contents("factorycode.txt", $_REQUEST["factoryCode"]);
                break;
            
            case "saveSecretKey";
                file_put_contents("secretkey.txt", $_REQUEST["secretKey"]);
                break;
            
            case "assignTaskToEmployee";
                sendApiRequest("assignTaskToEmployee", array(
                    "employeeId"    =>  $_REQUEST["employeeId"],
                    "taskId"        =>  $_REQUEST["taskId"]
                ));
                break;
            
            case "getOnlineEmployees";
                sendApiRequest("getOnlineEmployees");
                break;
            
            case "getTaskStatus";
                sendApiRequest("getTaskStatus", array(
                    "taskId"        =>  $_REQUEST["taskId"]
                ));
                break;
            
        }
        
        
        
    }
    
    function sendApiRequest($method, $data = array()) {
        $apikey     =   file_get_contents("apikey.txt");
        $factoryCode=   file_get_contents("factorycode.txt");
        
        if ($apikey == "") {
            echo "api key is empty!";
            exit;
        }
        if ($factoryCode == "") {
            echo "factory code is empty!";
            exit;
        }
        
        $host       =   "api.anti-captcha.com";
        
        $address    =   "http://$host/$method";
        
        $jsonData   =   json_encode(array_merge($data, array(
            "clientKey"     =>  $apikey,
            "factoryCode"   =>  $factoryCode
        )));
        
        
        $ch =   curl_init();
        curl_setopt($ch,CURLOPT_URL,$address);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS,$jsonData);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Accept: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));
        $result     =   curl_exec($ch);
        $curlError  =   curl_error($ch);
        curl_close($ch);
        
        if ($curlError != "") {
            echo "CURL error: $curlError";
            exit;
        }
        
        echo "Address: $address<br>";
        echo "Sending $jsonData<br>";
        echo "Raw response:<br><pre>".htmlentities($result)."</pre>";
        
        
        echo "Decoded:<pre>".print_r(json_decode($result, true), true)."</pre>";
        
    }