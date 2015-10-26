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
<?php include 'layout/layout-header.php'; ?>
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Users</h1>
            </div>
        </div>
    </div>
</div>


<div class="section">
    <div class="container">
        <div>
            <form action="" method="POST" class="form-dest" id="simple">
                <div class="form-group">
                    <input id="username" type="text" value="" name="username" placeholder="Search for a User" autofocus="autofocus" class="form-control col-md-10 home-input"/>
                    <button type="submit" class="btn btn-primary btn-wm col-md-1 pull-right">Enter</button>
                </div>
            </form>
        </div>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <div id="accordion">
            <h3>Advanced Search</h3>
            <div>
                <form class="form-horizontal" role="form" action="getUsersJSONAdvanced.php" method="post" id="advanced">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Email:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="sel1">Minimum Rating:</label>
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
                        <label class="control-label col-sm-2" for="sel1">Maximum Rating:</label>
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
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label><input type="checkbox" name="hasProject" id="hasProject">With Projects</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="numProjects">How many?</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" value="1" min="1" id="numProjects" name="numProjects" disabled>
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
        $('#hasProject').click(function() {
            if($("#hasProject").is(":checked")){
                $("#numProjects").prop('disabled', false);
            }else{
                $("#numProjects").prop('disabled', true);
                $("#numProjects").val(1);
            }
        })
        $("#simple").submit(function(ev){
            ev.preventDefault();
            var dataString = $(this).serialize();
            $.post('getUsersJSON.php', dataString, function(data) {
                var table = buildTable(data);

                $("#projectsTable").html(
                    table
                );

                function buildTable(data) {
                    //    alert(data);
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
                    //    alert(tmp);
                    return tmp;
                }

            });

            return false;
        });
        $("#advanced").submit(function(ev){
            ev.preventDefault();
            if($('#maxRating').val() < $('#minRating').val()) {
                $('#ratingErr').html('Maximum Rating must be larger than or equal to Minimum Rating');
            } else {
                var dataString = $(this).serialize();
                $.post('getUsersJSONAdvanced.php', dataString, function (data) {
                    var table = buildTable(data);

                    $("#projectsTable").html(
                        table
                    );

                    function buildTable(data) {
                        //    alert(data);
                        var dataJSON = jQuery.parseJSON(data);
                        var tmp = "<thead><tr>";
                        for (var header in dataJSON[0]) {
                            tmp = tmp + "<th>" + header + "</th>";
                        }
                        tmp = tmp + "<th>View</th>";
                        tmp = tmp + "</tr></thead>";
                        tmp = tmp + "<tbody>";
                        for (var i = 0; i < dataJSON.length; i++) {
                            var obj = dataJSON[i];
                            tmp = tmp + "<tr id='row" + i + "'>";
                            for (var header in obj) {
                                tmp = tmp + "<td><input type='hidden' value='" + obj[header] + "' name='" + header + "'/> " + obj[header] + "</td>";
                            }
                            tmp = tmp + "<td><button onclick=\"submitRowAsForm('row" + i + "')\">View</button></td>";
                            tmp = tmp + "</tr>";
                        }
                        tmp = tmp + "</tbody>";
                        //    alert(tmp);
                        return tmp;
                    }

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
        form.action = "userPage.php"; // TELL THE FORM WHAT PAGE TO SUBMIT TO
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
</script>
<?php include 'layout/layout-footer.php'; ?>
</body>
</html>
<?php
    oci_close($dbh);
?>