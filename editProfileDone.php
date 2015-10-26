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
                <h1>Edit Profile</h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <?php
        $email = $_SESSION['login_user'];
        $newPassword = $_POST['password'];
        $newAddress = $_POST['address'];
        $newPhone = $_POST['phone'];
        $newAcct = $_POST['acct'];
        $newName = $_POST['name'];
        $sql = "UPDATE member SET password = '".$newPassword."',address = '".$newAddress."',phone = '".$newPhone."',acct = '".$newAcct."',name = '".$newName."' WHERE email = '".$email."'";
        $res = oci_parse($dbh, $sql);
        if (oci_execute($res, OCI_COMMIT_ON_SUCCESS)) {
            oci_close($dbh);
            echo "<p>Your profile was updated successfully.</p>";
        } else {
            oci_close($dbh);
            echo "<p>Error! Your profile could not be updated (Perhaps your email address is already in use by someone else?)</p>";
        }
        echo "<a href='homepage.php'>Click here to return to the homepage</a>";
        ?>
    </div>
</div>


    <?php include 'layout/layout-footer.php'; ?>
</body>
</html>