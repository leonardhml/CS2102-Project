<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php include 'layout/config.php'; ?>
<?php include 'layout/layout-head.php'; ?>

<?php
$title = $_POST['Title'];
$inCharge = $_POST['In_Charge'];
$sql = "SELECT * FROM proposed_project WHERE title ='".$title."' AND in_charge='".$inCharge."'";
$project = oci_parse($dbh, $sql);
oci_execute($project, OCI_DEFAULT);

while ($row = oci_fetch_array($project, OCI_BOTH)) {
    $title = $row['TITLE'];
    $inCharge = $row['IN_CHARGE'];
    $startDate = $row['START_DATE'];
    $endDate = $row['END_DATE'];
    $propDate = $row['PROPOSAL_DATE'];
    $desc = $row['DESCRIPTION'];
    $proposer = $row['PROPOSER'];
    $target = $row['TARGET'];
    $raised = $row['RAISED'];
    $tag = $row['TAG'];
}

$sql = "SELECT avg(rating), count(rating) FROM p_vote WHERE p_title ='".$title."' AND p_in_charge='".$inCharge."' GROUP BY p_title, p_in_charge";
$project = oci_parse($dbh, $sql);
oci_execute($project, OCI_DEFAULT);

while ($row = oci_fetch_array($project, OCI_BOTH)) {
    $avgRating = $row[0];
    $count = $row[1];
}

oci_close($dbh);
?>

<head>
    <link rel="stylesheet" href="css/projectPage.css">
</head>
<body>
<?php include 'layout/layout-header.php'; ?>
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1><?php echo $title ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="description">
                <img class="img-responsive" src="img/proj_default.jpg" alt="">
                <div class="caption-full">
                <!--    <h4 class="pull-right">$24.99</h4> -->
                    <h4><a href="#"><?php echo $title; ?></a>
                    </h4>
                    <p><?php echo $desc; ?></p>

                    <table class="table table-bordered" id="projectTable">
                        <tr>
                            <td class="">Organisation</td>
                            <td><?php echo $inCharge; ?></td>
                        </tr>
                        <tr>
                            <td>Start Date</td>
                            <td><?php echo $startDate; ?></td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td><?php echo $endDate; ?></td>
                        </tr>
                        <tr>
                            <td>Proposal Date</td>
                            <td><?php echo $propDate; ?></td>
                        </tr>
                        <tr>
                            <td>By</td>
                            <td><?php echo $proposer; ?></td>
                        </tr>
                        <tr>
                            <td>Target</td>
                            <td>$<?php echo $target; ?></td>
                        </tr>
                        <tr>
                            <td>Raised</td>
                            <td>$<?php echo $raised; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="ratings">
                    <p>
                        <?php
                        for ($i = 0; $i < floor($avgRating); $i++) {
                            echo "<span class='glyphicon glyphicon-star'></span>";
                        }
                        for ($i = 0; $i<5-floor($avgRating);$i++) {
                            echo "<span class='glyphicon glyphicon-star-empty'></span>";
                        }
                        ?>
                        Rating: <?php if($avgRating) {echo $avgRating;} else {echo "0.00";} ?>/5.00 (<?php if($count) {echo $count;} else {echo "0";} ?> members voted on this project)
                    </p>
                </div>
            </div>


            <div class="col-md-6 text-center">
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
                        <input type="hidden" name="Title" value="<?php echo $title; ?>"/>
                        <input type="hidden" name="In_Charge" value="<?php echo $inCharge; ?>"/>
                    </span>
                    <button type="submit" class="btn btn-default">Rate this Project</button>
                </form>
            </div>

            <div class="col-md-6 text-center">
                <form class="form-inline" role="form" method="post" id="donateForm" action="donate.php">
                        <span class="form-group">
                            <label for="money">Donate to this Project:</label>
                            <input type="number" name="amount" class="form-control" id="ratings"/>
                            <input type="hidden" name="Title" value="<?php echo $title; ?>"/>
                            <input type="hidden" name="In_Charge" value="<?php echo $inCharge; ?>"/>
                        </span>
                    <button type="submit" class="btn btn-default">Donate</button>
                </form>
            </div>

            <button id="test"> click me </button>

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
            $.post('rate.php', dataString, function(data) {
                if (data) {
                    alert("Thank you for rating!");
                    location.reload();
                } else {
                    alert("You cannot rate a project twice!");
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