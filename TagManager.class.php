<?

    class TagManager {
      
      function TagManager() {
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
        $sql = "SELECT tag, COUNT(*) FROM proposed_project GROUP BY tag";
        $res = oci_parse($dbh, $sql);
        oci_execute($res, OCI_DEFAULT);
        $tags = array();
        
        while ($row = oci_fetch_array($res, OCI_BOTH)) {
            $row_array['Tag'] = $row[0];
            $row_array['In Charge'] = $row[1];
            array_push($tags, $row_array);
        }
        oci_close($dbh);
        return $tags; 
      }
    }

?>