<?php
session_start();
if (is_ajax() || !is_ajax()) {
    donate();
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

function donate(){
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

    $projectTitle = $_POST["Title"];
    $projectInCharge = $_POST["In_Charge"];
    $amount = $_POST["amount"];
    $donor = $_SESSION['login_user'];
    $sql = "INSERT INTO fund_record VALUES(LOCALTIMESTAMP, ".$amount.", '', seq_ID.nextval, '".$donor."', '".$projectTitle."', '".$projectInCharge."')";
    echo $sql;
    $res = oci_parse($dbh, $sql);
    oci_execute($res, OCI_COMMIT_ON_SUCCESS);
    $sql = "UPDATE proposed_project SET raised = raised + ".$amount." WHERE title = '".$projectTitle."' AND in_charge = '".$projectInCharge."'";
    $res = oci_parse($dbh, $sql);
    oci_execute($res, OCI_COMMIT_ON_SUCCESS);
    oci_close($dbh);
    //  echo true;
}
?>