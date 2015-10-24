
<!-- initialise oracle server -->
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