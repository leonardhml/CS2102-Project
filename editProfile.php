<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php include 'layout/config.php'; ?>
<?php include 'layout/layout-head.php'; ?>

<?php
echo print_r($_POST);
$email = $_SESSION['login_user'];
$sql = "SELECT * FROM member WHERE email ='".$email."'";
echo $sql;
$member = oci_parse($dbh, $sql);
oci_execute($member, OCI_DEFAULT);

while ($row = oci_fetch_array($member, OCI_BOTH)) {
    $email = $row['EMAIL'];
    $name = $row['NAME'];
    $address = $row['ADDRESS'];
    $password = $row['PASSWORD'];
    $is_admin = $row['IS_ADMIN'];
    $acct = $row['ACCT'];
    $phone= $row['PHONE'];
}

oci_close($dbh);
?>

<head>
    <link rel="stylesheet" href="css/userPage.css">
    <script src="js/userPage.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/lib/jquery-ui.js"></script>
    <script>
        $(function() {
            $( "#accordion" ).accordion({
                collapsible: true,
                active: false
            });
        });
    </script>
    <script>
        function submitRowAsForm(idRow) {
            var form = document.createElement("form"); // CREATE A NEW FORM TO DUMP ELEMENTS INTO FOR SUBMISSION
            form.method = "post"; // CHOOSE FORM SUBMISSION METHOD, "GET" OR "POST"
            form.action = "projectPage.php"; // TELL THE FORM WHAT PAGE TO SUBMIT TO
            $("#"+idRow+" td").children().each(function() { // GRAB ALL CHILD ELEMENTS OF <TD>'S IN THE ROW IDENTIFIED BY idRow, CLONE THEM, AND DUMP THEM IN OUR FORM
                if(this.type.substring(0,6) == "select") { // JQUERY DOESN'T CLONE <SELECT> ELEMENTS PROPERLY, SO HANDLE THAT
                    input = document.createElement("input"); // CREATE AN ELEMENT TO COPY VALUES TO
                    input.type = "hidden";
                    input.name = this.name; // GIVE ELEMENT SAME NAME AS THE <SELECT>
                    input.value = this.value; // ASSIGN THE VALUE FROM THE <SELECT>
                    form.appendChild(input);
                } else { // IF IT'S NOT A SELECT ELEMENT, JUST CLONE IT.
                    $(this).clone().appendTo(form);
                }

            });
            form.submit(); // NOW SUBMIT THE FORM THAT WE'VE JUST CREATED AND POPULATED
        }
    </script>
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

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >


            <div class="panel panel-info">
                <div class="panel-heading">
                    <h1 class="panel-title"><?php echo $name; ?></h1>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class=" col-md-12 col-lg-12 ">
                            <form action="editProfileDone.php" method="post" id="editProfile">
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>Email:</td>
                                        <td><input type="text" name="email" value="<?php echo $email ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Password:</td>
                                        <td><input type="password" name="password" value="<?php echo $password ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td><input type="text" name="address" value="<?php echo $address ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number:</td>
                                        <td><input type="text" name="phone" value="<?php echo $phone ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Bank Account (Only you can see this):</td>
                                        <td><input type="text" name="acct" value="<?php echo $acct ?>" /></td>
                                    </tr>
                                    </tbody>

                                    <button type="submit" class="btn btn-default">submit</button>
                                </table>
                            </form>
                        </div>
                    </div>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("document").ready(function(event){
        $("#test").click(function() {
            alert("jqueryworks");
        });

    });
</script>

<?php include 'layout/layout-footer.php'; ?>
</body>
</html>