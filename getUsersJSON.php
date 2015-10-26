<?php
session_start();
?>
<?php
if (is_ajax()) {
    get_users();
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

function get_users(){
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

    $username = $_POST["username"];
    $sql = "SELECT * FROM member WHERE email LIKE '%".$username."%' OR name LIKE '%".$username."%'";
    // echo $sql;
    $res = oci_parse($dbh, $sql);
    oci_execute($res, OCI_DEFAULT);
    $return_array = array();
    while ($row = oci_fetch_array($res, OCI_BOTH)) {
        $row_array['Email'] = $row['EMAIL'];
        $row_array['Name'] = $row['NAME'];
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