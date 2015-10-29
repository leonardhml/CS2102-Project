<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php include 'layout/config.php'; ?>
<?php include 'layout/layout-head.php'; ?>
<head>
    <script>
        $(function() {
            $( "#accordion" ).accordion({
                collapsible: true,
                active: false
            });
        });
    </script>
</head>
<body>
<div id="fly" style="position: absolute; top:50px; left: -50px;"><img src="img/steph0001.gif" /> </div>
<?php include 'layout/layout-header.php'; ?>
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Projects</h1>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div>
            <form action="" method="POST" class="form-dest" id="simple">
                <div class="form-group">
                    <input id="projTitle" type="text" value="<?php if(isset($_POST['projTitle'])) {echo $_POST['projTitle'];} else {echo "";} ?>" name="projTitle" placeholder="Search for a Project" autofocus="autofocus" class="form-control col-md-10 home-input"/>

                    <button type="submit" class="btn btn-primary btn-wm col-md-1 pull-right">Enter</button>
                </div>
            </form>
            <button type="button" id="test">click me</button>
        </div>
        <br/>
        <br/>
        <div id="accordion">
            <h3>Advanced Search</h3>
            <div>
                <form class="form-horizontal" role="form" action="getProjectsJSONAdvanced.php" method="post" id="advanced">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Title:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="by">By:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="by" name="by" placeholder="Enter organisation/proposer">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="sDate">Start Date:</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="sDate" name="sDate"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="eDate">End Date:</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="eDate" name="eDate"/>

                        </div><span id="dateErr" style='color: red'></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="minRating">Minimum Rating:</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="minRating" name="minRating">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="maxRating">Maximum Rating:</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="maxRating" name="maxRating">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div><span id="ratingErr" style='color: red'></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="tag">Tag:</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="tag" name="tag">
                                <?php
                                $sql = "SELECT * FROM tag";
                                $res = oci_parse($dbh, $sql);
                                oci_execute($res, OCI_DEFAULT);

                                while ($row = oci_fetch_array($res, OCI_BOTH)) {
                                    $tag = $row['WORD'];
                                    echo "<option>".$tag."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label><input type="checkbox" name="unfinished" id="unfinished">Search unfulfilled projects only</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br/>
        <br/>
    </div>
    <div class="container">
        <table class="table table-bordered" id="projectsTable">
        </table>
    </div>
</div>
<script type="text/javascript">
    $("document").ready(function(event){

        var isFromTagCloud = '<?php echo isset($_GET['fromTagCloud']); ?>';
        if (isFromTagCloud) {
            var tag = "<?php echo $_GET['tagFromTagCloud']; ?>";
            $.post('getProjectsJSON.php', {fromTagCloud:true, tagFromTagCloud: tag}, function(data) {
                var table = buildTable(data);

                $("#projectsTable").html(
                    table
                );


            });
        }

        $("#test").click(function() {
            $("#fly").animate({left: "+=500", top: "+=250"}, 3000);

        });

        $("#simple").submit(function(){
            var dataString = $(this).serialize();
            $.post('getProjectsJSON.php', dataString, function(data) {
                var table = buildTable(data);

                $("#projectsTable").html(
                    table
                );


            });

            return false;
        });

        $("#advanced").submit(function(ev){
            ev.preventDefault();
            if($('#maxRating').val() < $('#minRating').val()) {
                $('#ratingErr').html('Maximum Rating must be larger than or equal to Minimum Rating');
            } else if ($("#eDate").val() < $("#sDate").val()) {
                $("#dateErr").html('End date must be after start date');
            } else {
                var dataString = $(this).serialize();
                $.post('getProjectsJSONAdvanced.php', dataString, function (data) {
                    var table = buildTable(data);

                    $("#projectsTable").html(
                        table
                    );



                });

                return false;
            }
        });
    });
</script>
<script>
    function submitRowAsForm(idRow) {
        var form = document.createElement("form"); // CREATE A NEW FORM TO DUMP ELEMENTS INTO FOR SUBMISSION
        form.method = "post"; // CHOOSE FORM SUBMISSION METHOD, "GET" OR "POST"
        form.action = "projectPage.php"; // TELL THE FORM WHAT PAGE TO SUBMIT TO
        $("#"+idRow+" td").children().each(function() { // GRAB ALL CHILD ELEMENTS OF <TD>'S IN THE ROW IDENTIFIED BY idRow, CLONE THEM, AND DUMP THEM IN OUR FORM
            if(this.type.substring(0,6) == "select") { // JQUERY DOESN'T CLONE <SELECT> ELEMENTS PROPERLY, SO HANDLE THAT
                input = document.createElement("input"); // CREATE AN ELEMENT TO COPY VALUES TO
                input.type = "hidden";
                input.name = this.name; // GIVE ELEMENT SAME NAME AS THE <SELECT>
                input.value = this.value; // ASSIGN THE VALUE FROM THE <SELECT>
                form.appendChild(input);
            } else { // IF IT'S NOT A SELECT ELEMENT, JUST CLONE IT.
                $(this).clone().appendTo(form);
            }

        });
        form.submit(); // NOW SUBMIT THE FORM THAT WE'VE JUST CREATED AND POPULATED
    }

    function buildTable(data) {
        //  alert(data);
        var dataJSON = jQuery.parseJSON(data);
        var tmp = "<thead><tr>";
        for (var header in dataJSON[0] ) {
            tmp = tmp + "<th>" + header + "</th>";
        }
        tmp = tmp + "<th>View</th>";
        tmp = tmp + "</tr></thead>";
        tmp = tmp + "<tbody>";
        for (var i = 0; i<dataJSON.length;i++) {
            var obj = dataJSON[i];
            tmp = tmp + "<tr id='row" + i + "'>";
            for(var header in obj) {
                tmp=tmp+"<td><input type='hidden' value='"+obj[header]+"' name='"+header+"'/> "+obj[header]+"</td>";
            }
            tmp = tmp + "<td><button onclick=\"submitRowAsForm('row"+i+"')\">View</button></td>";
            tmp = tmp + "</tr>";
        }
        tmp = tmp + "</tbody>";
        //   alert(tmp);
        return tmp;
    }
</script>
<?php include 'layout/layout-footer.php'; ?>
</body>
</html>
<?php
oci_close($dbh);
?>