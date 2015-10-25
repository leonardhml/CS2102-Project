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
                <h1>Register</h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <?php
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $acct = $_POST['acct'];
        $phone = $_POST['phone'];
        $isAdmin = 0;
        $sql = "INSERT INTO member VALUES ('".$email."', '".$name."', '".$address."', '".$password."', ".$isAdmin.", ".$acct.", '".$phone."')";
        echo $sql;
        $res = oci_parse($dbh, $sql);
        if (oci_execute($res, OCI_COMMIT_ON_SUCCESS)) {
            oci_close($dbh);
            echo "<p>Registration Successful.</p>";
        } else {
            oci_close($dbh);
            echo "<p>Error! Registration Failed.</p>";
        }
        echo "<a href='homepage.php'>Click here to return to the homepage</a>";
        ?>
    </div>
</div>


<?php include 'layout/layout-footer.php'; ?>
</body>
</html>