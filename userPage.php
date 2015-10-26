<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php include 'layout/config.php'; ?>
<?php include 'layout/layout-head.php'; ?>

<?php
$email = $_POST['Email'];
$sql = "SELECT * FROM member WHERE email ='".$email."'";
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

$sql = "SELECT to_char(avg(rating), '0.99'), count(rating) FROM m_vote WHERE votee='".$email."' GROUP BY votee";
$project = oci_parse($dbh, $sql);
oci_execute($project, OCI_DEFAULT);

while ($row = oci_fetch_array($project, OCI_BOTH)) {
    $avgRating = $row[0];
    $count = $row[1];
}

oci_close($dbh);
?>

<head>
    <link rel="stylesheet" href="css/userPage.css">
    <script src="js/userPage.js"></script>
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
                <h1>User</h1>
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
                        <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="img/profile_default.png" class="img-circle img-responsive"> </div>

                        <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                          <dl>
                            <dt>DEPARTMENT:</dt>
                            <dd>Administrator</dd>
                            <dt>HIRE DATE</dt>
                            <dd>11/12/2013</dd>
                            <dt>DATE OF BIRTH</dt>
                               <dd>11/12/2013</dd>
                            <dt>GENDER</dt>
                            <dd>Male</dd>
                          </dl>
                        </div>-->
                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>Email:</td>
                                    <td><?php echo $email ?></td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td><?php echo $address ?></td>
                                </tr>
                                <tr>
                                    <td>Phone Number:</td>
                                    <td><?php echo $phone ?></td>
                                </tr>
                                <tr>
                                    <td>Administrator?</td>
                                    <td><?php if($is_admin) {echo "Yes";} else {echo "No";} ?></td>
                                </tr>
                                <tr>
                                    <td>Rating:</td>
                                    <td><?php
                                        for ($i = 0; $i < floor($avgRating); $i++) {
                                            echo "<span class='glyphicon glyphicon-star'></span>";
                                        }
                                        for ($i = 0; $i<5-floor($avgRating);$i++) {
                                            echo "<span class='glyphicon glyphicon-star-empty'></span>";
                                        }
                                        ?>
                                        Rating: <?php if($avgRating) {echo $avgRating;} else {echo "0.00";} ?>/5.00 (<?php if($count) {echo $count;} else {echo "0";} ?> Votes)
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div id="accordion">
                                <h3>Projects</h3>
                                <div>
                                    <table style="width:100%" class="table table-bordered" id="projectsTable">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>View</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        putenv('ORACLE_HOME=/oraclient');
                                        $nusnetid = 'a0127393';
                                        $nusnetpw = 'crse1510';
                                        $dbh = ocilogon($nusnetid, $nusnetpw, ' (DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = sid3.comp.nus.edu.sg)))');
                                        $sql = "SELECT * FROM proposed_project WHERE proposer ='".$email."'";
                                        // echo $sql;
                                        $res = oci_parse($dbh, $sql);
                                        oci_execute($res, OCI_DEFAULT);
                                        $i = 0;
                                        while ($row = oci_fetch_array($res, OCI_BOTH)) {
                                            $title = $row['TITLE'];
                                            $desc= $row['DESCRIPTION'];
                                            $inCharge=$row['IN_CHARGE'];
                                            echo "<tr id='row".$i."'><td><input type='hidden' name='Title' value='".$title."'/><input type='hidden' name='In Charge' value='".$inCharge."'/>".$title."</td><td>".$desc."</td><td><button onclick=\"submitRowAsForm('row".$i."')\">View</button></td></tr>";
                                            $i++;
                                        }
                                        oci_close($dbh);
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <form class="form-inline" role="form" method="post" id="ratingForm" action="rate.php">
                    <span class="form-group">
                        <label for="rating">Your Rating:</label>
                        <select name="ratings" class="form-control" id="ratings">
                            <option>1.00</option>
                            <option>2.00</option>
                            <option>3.00</option>
                            <option>4.00</option>
                            <option>5.00</option>
                        </select>
                        <input type="hidden" name="votee" value="<?php echo $email; ?>"/>
                    </span>
                        <button type="submit" class="btn btn-default">Rate this User</button>
                    </form>
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
        $("#ratingForm").submit(function(){
            var dataString = $(this).serialize(); //should only have 3 data: ratings, projTitle, projInCharge
            $.post('rateUser.php', dataString, function(data) {
                if (data) {
                    alert("Thank you for rating!");
                    location.reload();
                } else {
                    alert("You cannot rate a user twice!");
                }
            });

            return false;
        })  ;

        $("#donateForm").submit(function(){
            var dataString = $(this).serialize(); //should only have 3 data: ratings, projTitle, projInCharge
            $.post('donate.php', dataString, function(data) {
                alert("Thank you for donating!");
                location.reload();
            });

            return false;
        });
    });
</script>

<?php include 'layout/layout-footer.php'; ?>
</body>
</html>