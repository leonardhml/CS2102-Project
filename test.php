<html>

<head>
    <title>Demo Online Book Catalog</title>
    <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
</head>

<body>
<div class="header">
    <h1 id="title">Crowdfunding 'R' Us</h1>
    <h2 id="subtitle">Please Give Us Money</h2>
</div>
<br></br>
<table>
    <thead>
    <tr>
        <th colspan="2">Available projects</th>
    </tr>
    </thead>
    <?php
    putenv('ORACLE_HOME=/oraclient');
    $nusnetid = 'a0127393';
    $nusnetpw = 'crse1510';
    $dbh = ocilogon($nusnetid, $nusnetpw, ' (DESCRIPTION =
                    (ADDRESS_LIST =
                        (ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
                        )
                (CONNECT_DATA =
                    (SERVICE_NAME = sid3.comp.nus.edu.sg)
                    )
                )');
    ?>
    <tr>
        <td id="form" >
            <form>
                Title: <input type="text" name="Title" id="formTitle">
                <select name="Language"> <option value="">Select Language</option>
                    <?php
                    $sql = "SELECT DISTINCT language FROM book";
                    $stid = oci_parse($dbh, $sql);
                    oci_execute($stid, OCI_DEFAULT);
                    while($row = oci_fetch_array($stid)){
                        echo "<option value=\"".$row["LANGUAGE"]."\">".$row["LANGUAGE"]."</option><br>";
                    }
                    oci_free_statement($stid);
                    ?>
                </select>
                <input type="radio" name="Format" id="Format1" value="hardcover">hardcover
                <input type="radio" name="Format" id="Format2" value="paperback">paperback
                <input type="submit" name="formSubmit" value="Search" >
            </form>
            <?php
            if(isset($_GET['formSubmit']))
            {
                $sql = "SELECT Title, Authors FROM Book WHERE Title like '%".$_GET['Title']."%' AND Language='".$_GET['Language']."' AND Format='".$_GET['Format']."'";
                echo "<b>SQL: </b>".$sql."<br><br>";
                $stid = oci_parse($dbh, $sql);
                oci_execute($stid, OCI_DEFAULT);
                echo "<table border=\"1\" >
            <col width=\"75%\">
            <col width=\"25%\">
            <tr>
                <th>Title</th>
                <th>Authors</th>
            </tr>";
                while($row = oci_fetch_array($stid)) {
                    echo "<tr>";
                    echo "<td>" . $row[0] . "</td>";
                    echo "<td>" . $row[1] . "</td>";
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