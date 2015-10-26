<?php
session_start();
if (is_ajax() || !is_ajax()) {
    rate();
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

function rate()
{
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

    $votee = $_POST["votee"];
    $rating = $_POST["ratings"];
    $voter = $_SESSION['login_user'];
    $sql = "INSERT INTO m_vote VALUES(" . $rating . ", '" . $voter . "', '" . $votee . "')";
    //echo $sql;
    $res = oci_parse($dbh, $sql);
    if (@oci_execute($res, OCI_COMMIT_ON_SUCCESS)) {
        oci_close($dbh);
        echo true;
    } else {
        oci_close($dbh);
        echo false;
    }
}
?>