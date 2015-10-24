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
                <h1>Login</h1>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="login-block row">
            <form action="login.php" method="POST" class="form-signin">
                <input id="email" type="text" value="" placeholder="Email" name="email" required="required" autofocus="autofocus" class="form-control"/>
                <input id="password" type="password" value="" placeholder="Password" name="password" required="required" class="form-control"/>
                <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block login-btn">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'layout/layout-footer.php'; ?>
<?php include 'layout/layout-scripts.php'; ?>
</body>
</html>
