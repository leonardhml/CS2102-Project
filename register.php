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
                <h1>Register</h1>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="login-block row">
            <form action="registerSuccess.php" method="POST" class="form-signin">
                <input id="email" type="text" value="" placeholder="Email" name="email" required="required" autofocus="autofocus" class="form-control"/>
                <input id="name" type="text" value="" placeholder="Name" name="name" required="required" class="form-control"/>
                <input id="password" type="password" value="" placeholder="Password" name="password" required="required" class="form-control"/>
                <input id="address" type="text" value="" placeholder="Address" name="address" required="required" class="form-control"/>
                <input id="acct" type="text" value="" placeholder="Bank Account Number" name="acct" required="required" class="form-control"/>
                <input id="phone" type="text" value="" placeholder="Phone Number" name="phone" required="required" class="form-control"/>
                <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block login-btn">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'layout/layout-footer.php'; ?>
</body>
</html>
