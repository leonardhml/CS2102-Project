<?php
if (is_ajax()) {
    get_projects();
   // if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
   //     $action = $_POST["action"];
   //     switch($action) { //Switch case for value of action
   //         case "getProjects": get_projects(); break;
   //     }
   // }
}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function get_projects(){
    putenv('ORACLE_HOME=/oraclient');
    $nusnetid = 'a0127393';
    $nusnetpw = 'crse1510';
    $dbh = ocilogon($nusnetid, $nusnetpw, ' (DESCRIPTION =
                    (ADDRESS_LIST =
                        (ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
                        )
                (CONNECT_DATA =
                    (SERVICE_NAME = sid3.comp.nus.edu.sg)
                    )
                )');
    $projectTitle = $_POST["projTitle"];
    $sql = "SELECT * FROM proposed_project WHERE title LIKE '%".$projectTitle."%'";
   // echo $sql;
    $res = oci_parse($dbh, $sql);
    oci_execute($res, OCI_DEFAULT);
    $return_array = array();
    while ($row = oci_fetch_array($res, OCI_BOTH)) {
        $row_array['title'] = $row[0];
        $row_array['in_charge'] = $row['IN_CHARGE'];
        $row_array['proposer'] = $row['PROPOSER'];
        $row_array['start_date'] = $row['START_DATE'];
        $row_array['end_date'] = $row['END_DATE'];
        $row_array['target'] = $row['TARGET'];
        $row_array['raised'] = $row['RAISED'];
        $row_array['description'] = $row['DESCRIPTION'];
        array_push($return_array, $row_array);
    }
    //Do what you need to do with the info. The following are some examples.
    //if ($return["favorite_beverage"] == ""){
    //  $return["favorite_beverage"] = "Coke";
    //}
    //$return["favorite_restaurant"] = "McDonald's";
    oci_close($dbh);
    echo json_encode($return_array);
}
?>