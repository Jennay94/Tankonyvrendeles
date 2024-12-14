<?php

//include './db.php';


// engedélyezek minden OPTIONS kérést (REQUEST)





$resurce = strtok($_SERVER['QUERY_STRING'], '=');


if($resurce == 'restapi')
{
    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
    {
        $data = true;
        return;
    }
    
   require('restapi.php');
}




// Válasz visszaküldése JSON formátumban

echo json_encode(['status' => 'success', 'receivedData' => $data]);

?>