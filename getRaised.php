<?php
function getRaised($title, $inCharge) {

    putenv('ORACLE_HOME=/oraclient');
    $nusnetid = 'a0127393';
    $nusnetpw = 'crse1510';
    $database = ocilogon($nusnetid, $nusnetpw, ' (DESCRIPTION =
                    (ADDRESS_LIST =
                        (ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
                        )
                (CONNECT_DATA =
                    (SERVICE_NAME = sid3.comp.nus.edu.sg)
                    )
                )');

    $sql = "SELECT sum(amount) FROM fund_record WHERE p_title = '".$title."' AND p_in_charge = '".$inCharge."'";

    $results = oci_parse($database, $sql);
    oci_execute($results);
    $raised = 0;
    while ($row = oci_fetch_array($results, OCI_BOTH)) {
        $raised = $row[0];
    }
    oci_close($database);
    return $raised;
}
?>