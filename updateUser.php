

<html>

<head>
    <title>SteFund - Your one-stop shop for all things crowdfunding!</title>
    <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
</head>


<body>
<?php
include 'config.php'
?>
<form method="post" action="updateUser.php">
<?php
$sql = "SELECT * FROM member";
$stid = oci_parse($dbh, $sql);
oci_execute($stid, OCI_DEFAULT);

$ncols = oci_num_fields($stid);

echo "<table border=\"1\">
        <thead>
           <tr>";
echo "<th>Email</th>";
echo "<th>Name</th>";
echo "<th>Address</th>";
echo "<th>Password</th>";
echo "<th>Is_admin</th>";
echo "<th>Account</th>";
echo "<th>Phone no.</th>";
echo "</tr> </thead>" ;

$i = 0;

while($row = oci_fetch_array($stid)) {
    echo "<tr>";

    echo "<td>";
    echo '<input type="text" value="'.$row[0].'" name="email'.$i.'" readonly />';
    echo "</td>";

    echo "<td>";
    echo '<input type="text" value="'.$row[1].'" name="name'.$i.'"  />';
    echo "</td>";

    echo "<td>";
    echo '<input type="text" value="'.$row[2].'" name="add'.$i.'"  />';
    echo "</td>";

    echo "<td>";
    echo '<input type="text" value="'.$row[3].'" name="pw'.$i.'"  />';
    echo "</td>";

    echo "<td>";
    echo '<select  name="ia'.$i.'"/>';
    $tmp = $row[4];
    if (intval($tmp) == 1) {
        echo '<option value="0">0</option>';
        echo '<option value="1" selected>1</option>';
    } else {
        echo '<option value="0" selected>0</option>';
        echo '<option value="1">1</option>';
    }
    echo '</select>';

    echo "</td>";


    echo "<td>";
    echo '<input type="text" value="'.$row[5].'" name="acct'.$i.'"  />';
    echo "</td>";

    echo "<td>";
    echo '<input type="text" value="'.$row[6].'" name="phone'.$i.'"  />';
    echo "</td>";

    echo "<td>";
    echo '<input type="submit" value="update" name="update'.$i.'" />';
    if (isset($_POST['update'.$i.''])) {
        $email = $_POST['email'.$i.''];
        $name = $_POST['name'.$i.''];
        $add = $_POST['add'.$i.''];
        $pw = $_POST['pw'.$i.''];
        $ia = $_POST['ia'.$i.''];
        $acct = $_POST['acct'.$i.''];
        $phone = $_POST['phone'.$i.''];

        $update = "UPDATE member SET name='$name', address='$add', password='$pw', is_admin=$ia, acct='$acct', phone='$phone' WHERE email='$email'";
        $updateParse = oci_parse($dbh,$update);

        oci_execute($updateParse,OCI_DEFAULT);
        oci_commit($dbh);
        oci_free_statement($updateParse);
        echo "<script type='text/javascript'>window.location=\"http://cs2102-i.comp.nus.edu.sg/~a0127393/updateUser.php\";</script>";
    }
    echo "</td>";

    echo "<td>";
    echo '<input type="submit" value="delete" name="delete'.$i.'" />';
    if (isset($_POST['delete'.$i.''])) {
        $email = $_POST['email'.$i.''];
        $name = $_POST['name'.$i.''];
        $add = $_POST['add'.$i.''];
        $pw = $_POST['pw'.$i.''];
        $ia = $_POST['ia'.$i.''];
        $acct = $_POST['acct'.$i.''];
        $phone = $_POST['phone'.$i.''];

        $update = "DELETE FROM member WHERE email='$email'";
        $updateParse = oci_parse($dbh,$update);

        oci_execute($updateParse,OCI_DEFAULT);
        oci_commit($dbh);
        oci_free_statement($updateParse);
        echo "<script type='text/javascript'>window.location=\"http://cs2102-i.comp.nus.edu.sg/~a0127393/updateUser.php\";</script>";
    }
    echo "</td>";

    echo "</tr>";

    $i++;
}
echo "</table>";

oci_free_statement($stid);
oci_close($dbh)
?>
    </form>
<a href="steFund.php">Main</a>
</body>

</html>