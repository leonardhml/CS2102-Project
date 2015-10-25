<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php include 'layout/config.php'; ?>
<?php include 'layout/layout-head.php'; ?>

<head>
    <link rel="stylesheet" href="css/userPage.css">
    <script src="js/userPage.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/lib/jquery-ui.js"></script>
</head>

<body>
<?php include 'layout/layout-header.php'; ?>
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Project Proposal</h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <?php
        $title = $_POST['title'];
        $inCharge = $_POST['inCharge'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $target = $_POST['target'];
        $bankAcct = $_POST['bankAcct'];
        $description = $_POST['description'];
        $tag = $_POST['tag'];
        $proposer = $_POST['proposer'];
        $propDate = $_POST['propDate'];
        $raised = 0;
        $sql = "INSERT INTO proposed_project VALUES ('".$title."', '".$inCharge."', TO_DATE('".$startDate."', 'YYYY-MM-DD'), TO_DATE('".$endDate."', 'YYYY-MM-DD'), TO_DATE('".$propDate."', 'DD/MON/YYYY'), '".$description."', '".$proposer."', ".$target.", ".$raised.", '".$tag."', '".$bankAcct."', 0)";

        $res = oci_parse($dbh, $sql);
        if (oci_execute($res, OCI_COMMIT_ON_SUCCESS)) {
            oci_close($dbh);
            echo "<p>Your project was uploaded successfully.</p>";
        } else {
            oci_close($dbh);
            echo "<p>Error! Your project could not be uploaded.</p>";
        }
        echo "<a href='homepage.php'>Click here to return to the homepage</a>";
        ?>
    </div>
</div>


<?php include 'layout/layout-footer.php'; ?>
</body>
</html>