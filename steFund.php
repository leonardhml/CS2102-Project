<html>

<head>
    <title>SteFund - Your one-stop shop for all things crowdfunding!</title>
    <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
</head>

<?php
include 'config.php';
?>

<body>
<div class="header">
    <h1 id="title">SteFund inc.</h1>
    <h2 id="subtitle">Please Give Us Money</h2>
</div>
<div class="menu">
    <a href="updateUser.php">Update users</a><br>
    <a href="insert.php">Insert a user</a>

</div>
<table>
    <thead>
    <tr>
        <th colspan="2">Available projects</th>
    </tr>
    </thead>

    <tr>
        <td id="form" >
            <form>
                Title: <input type="text" name="Title" id="formTitle">
                <input type="submit" name="formSubmit" value="Search" >
            </form>
            <?php
            if(isset($_GET['formSubmit']))
            {
                $sql = "SELECT title, in_charge, start_date, end_date, target, raised, description FROM proposed_project WHERE title like '%".$_GET['Title']."%'";
                $stid = oci_parse($dbh, $sql);
                oci_execute($stid, OCI_DEFAULT);
                echo "<table id=\"results\" >
            <tr>
                <th>Title</th>
                <th>Organisation</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Target Goal</th>
                <th>Raised</th>
                <th>Description</th>
            </tr>";
                while($row = oci_fetch_array($stid)) {
                    echo "<tr>";
                    echo "<td>" . $row[0] . "</td>";
                    echo "<td>" . $row[1] . "</td>";
                    echo "<td>" . $row[2] . "</td>";
                    echo "<td>" . $row[3] . "</td>";
                    echo "<td>" . $row[4] . "</td>";
                    echo "<td>" . $row[5] . "</td>";
                    echo "<td>" . $row[6] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                oci_free_statement($stid);
            }
            ?>
        </td>
    </tr>

    <?php
    oci_close($dbh);
    ?>

    <tr>
        <td colspan="2" style="background-color:#FFA500; text-align:center;">
            Copyright &#169; CS2102
        </td>
    </tr>
</table>
</body>
</html>