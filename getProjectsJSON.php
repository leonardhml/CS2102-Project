<?php
if (is_ajax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        $action = $_POST["action"];
        switch($action) { //Switch case for value of action
            case "getProjects": get_projects(); break;
        }
    }
}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function get_projects(){
    include 'layout/config.php';
    $projectTitle = $_POST["projTitle"];
    $sql = "SELECT title, in_charge, proposer, start_date, end_date, target, raised, description FROM proposed_project WHERE title LIKE '%'$projectTitle'%'";

    $res = oci_parse($dbh, sql);
    oci_execute($res, OCI_DEFAULT);
    $return_array = array();
    while ($row = oci_fetch_array($res)) {
        $row_array['title'] = $row['title'];
        $row_array['in_charge'] = $row['in_charge'];
        $row_array['proposer'] = $row['proposer'];
        $row_array['start_date'] = $row['start_date'];
        $row_array['end_date'] = $row['end_date'];
        $row_array['target'] = $row['target'];
        $row_array['raised'] = $row['raised'];
        $row_array['description'] = $row['description'];
        array_push($return_array, $row_array);
    }
    //Do what you need to do with the info. The following are some examples.
    //if ($return["favorite_beverage"] == ""){
    //  $return["favorite_beverage"] = "Coke";
    //}
    //$return["favorite_restaurant"] = "McDonald's";

    echo json_encode($return_array);
}
?>