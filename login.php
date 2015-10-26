<?php
session_start();
?>
<?php
session_start(); // Starting Session
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
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";
    }
    else
    {
// Define $username and $password
        $email=$_POST['email'];
        $password=$_POST['password'];
// To protect MySQL injection for Security purpose
//        $username = stripslashes($username);
//        $password = stripslashes($password);
//       $username = oci_($username);
//        $password = mysql_real_escape_string($password);
// SQL query to fetch information of registerd users and finds user match.
        $query = "SELECT email FROM member WHERE email='$email' AND password='$password'";
        $parseLogin = oci_parse($dbh, $query);
        oci_execute($parseLogin, OCI_DEFAULT);
        if ($row = oci_fetch_array($parseLogin)) {
            $_SESSION['login_user']=$row[0]; // store email in session variable
            header("location: homepage.php"); // Redirecting To Other Page
        } else {
            $error = "Username or Password is invalid";
            echo "Login failed. Please click <a href='homepage.php'>here</a> to return to the homepage.";
        }
        oci_close($dbh);
//        mysql_close($connection); // Closing Connection
    }
}
?>