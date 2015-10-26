<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<?php include 'layout/config.php'; ?>
<?php include 'layout/layout-head.php'; ?>
<body>
<?php include 'layout/layout-header.php'; ?>
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Propose a Project</h1>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="col-md-10">
            <form action="submitSuccess.php" method="POST" class="form-signin" id="submit">
                <input id="title" type="text" value="" placeholder="Title" name="title" required="required" autofocus="autofocus" class="form-control"/><br/>
                <input id="inCharge" type="text" value="" placeholder="Organisation" name="inCharge" required="required" autofocus="autofocus" class="form-control"/><br/>
                <input id="startDate" type="date" value="" placeholder="Start Date" name="startDate" required="required" autofocus="autofocus" class="form-control"/><br/>
                <input id="endDate" type="date" value="" placeholder="End Date" name="endDate" required="required" autofocus="autofocus" class="form-control"/><br/>
                <input id="target" type="number" value="" placeholder="Target Amount (in $)" name="target" required="required" autofocus="autofocus" class="form-control"/><br/>
                <input id="bankAcct" type="text" value="" placeholder="Bank Account Number" name="bankAcct" required="required" autofocus="autofocus" class="form-control"/><br/>
                <textarea name="description" placeholder="Enter a description of your project" form="submit" rows="6" cols="128"></textarea><br/>
                <div class="form-group">
                    <label for="sel1">Select a Tag:</label>
                    <select class="form-control" id="tag" name="tag">
                        <?php
                        $sql = "SELECT * FROM tag";
                        $res = oci_parse($dbh, $sql);
                        oci_execute($res, OCI_DEFAULT);

                        while ($row = oci_fetch_array($res, OCI_BOTH)) {
                            $tag = $row['WORD'];
                            echo "<option>".$tag."</option>";
                        }
                        ?>
                    </select>
                </div><br/>
                <input type="hidden" name="proposer" value="<?php echo $_SESSION['login_user'];?>"/>
                <input type="hidden" name="propDate" value="<?php date_default_timezone_set('UTC'); echo date('d/M/Y');?>"/>
                <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block login-btn">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'layout/layout-footer.php'; ?>
<?php
oci_close($dbh);
?>
</body>
</html>
