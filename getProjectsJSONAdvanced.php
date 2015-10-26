<?php
session_start();
?>
<?php
if (is_ajax() || !is_ajax()) {
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

    $title = $_POST["title"];
    $by = $_POST["by"];
    $sDate = ($_POST["sDate"]) ? $_POST["sDate"] : '0001-01-01';
    $eDate = ($_POST["eDate"]) ? $_POST["eDate"] : '9999-12-30';
    $minRating = $_POST["minRating"];
    $maxRating = $_POST["maxRating"];
    $tag = $_POST["tag"];
    $wantsUnfinished= $_POST["unfinished"];

    if ($minRating >= 1) {
        $sql = "SELECT *
    FROM proposed_project p
    WHERE (p.title LIKE '%" . $title . "%' AND (p.in_charge LIKE '%" . $by. "%' OR p.proposer LIKE '%" . $by. "%'))
    AND (p.start_date >= TO_DATE('".$sDate."', 'YYYY-MM-DD') AND p.end_date <= TO_DATE('".$eDate."', 'YYYY-MM-DD'))
    AND p.tag = '".$tag."'
    AND (EXISTS (
        SELECT v.p_title, v.p_in_charge
        FROM p_vote v
        WHERE v.p_title = p.title
        AND v.p_in_charge = p.in_charge
        GROUP BY v.p_title, v.p_in_charge
        HAVING avg(v.rating)>= " . $minRating . " AND avg(v.rating)<= " . $maxRating . "))";
    } else {
        $sql = "SELECT *
    FROM proposed_project p
    WHERE (p.title LIKE '%" . $title . "%' AND (p.in_charge LIKE '%" . $by. "%' OR p.proposer LIKE '%" . $by. "%'))
    AND (p.start_date >= TO_DATE('".$sDate."', 'YYYY-MM-DD') AND p.end_date <= TO_DATE('".$eDate."', 'YYYY-MM-DD'))
    AND p.tag = '".$tag."'
    AND (EXISTS (
        SELECT v.p_title, v.p_in_charge
        FROM p_vote v
        WHERE v.p_title = p.title
        AND v.p_in_charge = p.in_charge
        GROUP BY v.p_title, v.p_in_charge
        HAVING avg(v.rating)>= " . $minRating . " AND avg(v.rating)<= " . $maxRating . ")
    OR NOT EXISTS (
        SELECT *
        FROM p_vote vo
        WHERE vo.p_title= p.title
        AND vo.p_in_charge = p.in_charge))";
    }

    if ($wantsUnfinished) {
        $sql = $sql.
            "AND(
                (EXISTS(
                    SELECT *
                    FROM fund_record f
                    WHERE f.p_title = p.title
                    AND f.p_in_charge = p.in_charge)
                AND p.target > (
                    SELECT sum(f2   .amount)
                    FROM fund_record f2
                    WHERE f2.p_title = p.title
                    AND f2.p_in_charge = p.in_charge)
            OR NOT EXISTS (
            SELECT *
            FROM fund_record fu
            WHERE fu.p_title = p.title
            AND fu.p_in_charge = p.in_charge)))";
    }
    $res = oci_parse($dbh, $sql);
    oci_execute($res, OCI_DEFAULT);
    $return_array = array();
    while ($row = oci_fetch_array($res, OCI_BOTH)) {
        $row_array['Title'] = $row[0];
        $row_array['In Charge'] = $row['IN_CHARGE'];
        $row_array['Proposer'] = $row['PROPOSER'];
        $row_array['Start Date'] = $row['START_DATE'];
        $row_array['End Date'] = $row['END_DATE'];
        $row_array['Target'] = $row['TARGET'];
        $row_array['Raised'] = $row['RAISED'];
        $row_array['Description'] = $row['DESCRIPTION'];
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

