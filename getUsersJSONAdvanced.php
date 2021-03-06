<?php
session_start();
?>
<?php
if (is_ajax() || !is_ajax()) {
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

    $email = $_POST["email"];
    $name = $_POST["name"];
    $minRating = $_POST["minRating"];
    $maxRating = $_POST["maxRating"];
    $hasProject = $_POST["hasProject"];
    $numProjects = $_POST["numProjects"];

    if ($minRating >= 1) {
        $sql = "SELECT *
    FROM member m
    WHERE (m.email LIKE '%" . $email . "%' AND m.name LIKE '%" . $name . "%')
    AND EXISTS (
        SELECT v.votee
        FROM m_vote v
        WHERE v.votee = m.email
        GROUP BY v.votee
        HAVING avg(v.rating)>= " . $minRating . " AND avg(v.rating)<= " . $maxRating . ")";
    } else {
        $sql = "SELECT *
    FROM member m
    WHERE (m.email LIKE '%" . $email . "%' AND m.name LIKE '%" . $name . "%')
    AND (EXISTS (
        SELECT v.votee
        FROM m_vote v
        WHERE v.votee = m.email
        GROUP BY v.votee
        HAVING avg(v.rating)>= " . $minRating . " AND avg(v.rating)<= " . $maxRating . ")
    OR NOT EXISTS (
        SELECT *
        FROM m_vote vo
        WHERE vo.votee = m.email))";
    }

    if ($hasProject) {
        $sql = $sql.
            "AND EXISTS (
            SELECT p.proposer
            FROM proposed_project p
            WHERE p.proposer = m.email
            GROUP BY p.proposer
            HAVING COUNT(*) =".$numProjects.")";
    }
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