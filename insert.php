<html>

<!-- initialise oracle server -->
<?php
include 'config.php';
?>
<form>
    Email:<br>
    <input type="text" name="email">
    <br>
    Name:<br>
    <input type="text" name="name">
    <br>
    Address:<br>
    <input type="text" name="add">
    <br>
    Password:<br>
    <input type="password" name="pw"> <br>
    Grant admin rights:<br>
    <input type="radio" name="admin" value="1">Yes<br>
    <input type="radio" name="admin" value="0">No<br>
    Bank account: <br>
    <input type="text" name="acct">
    <br>
    Phone number: <br>
    <input type="text" name="phone"> <br>

    <input type="submit" name="submit" value="Submit">

</form>

<?php
if(isset($_GET['submit']))
{
    $sql = "INSERT INTO member VALUES ('".$_GET['email']."', '".$_GET['name']."','".$_GET['add']."','".$_GET['pw']."',".$_GET['admin'].",'".$_GET['acct']."','".$_GET['phone']."')";
    echo "<b>SQL: </b>".$sql."<br><br>";
    $stid = oci_parse($dbh, $sql);
    oci_execute($stid, OCI_DEFAULT);
    echo "User added!";
    oci_commit($dbh);
    oci_free_statement($stid);
}
?>


<?php
oci_close($dbh);
?>

</html>