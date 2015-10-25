<?php
session_start();
?>
<!DOCTYPE html>
<html>
<?php include 'layout/config.php'; ?>
<?php include 'layout/layout-head.php'; ?>
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
        <form action="" method="POST" class="form-dest">
            <div class="form-group">
                <input id="projTitle" type="text" value="<?php if(isset($_POST['projTitle'])) {echo $_POST['projTitle'];} else {echo "";} ?>" name="projTitle" placeholder="Search for a Project" autofocus="autofocus" class="form-control col-md-10 home-input"/>

                <button type="submit" class="btn btn-primary btn-wm col-md-1 pull-right">Enter</button>
            </div>
        </form>
        <button type="button" id="test">click me</button>
    </div>
    <div class="container">
        <table class="table table-bordered" id="projectsTable">
        </table>
    </div>
</div>
<script type="text/javascript">
    $("document").ready(function(event){
        $("#test").click(function() {
            $("#fly").animate({left: "+=500", top: "+=250"}, 3000);

        });
        $(".form-dest").submit(function(){
            var dataString = $(this).serialize();
            $.post('getProjectsJSON.php', dataString, function(data) {
                var table = buildTable(data);

                $("#projectsTable").html(
                    table
                );

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

            });

            return false;
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
</script>
<?php include 'layout/layout-footer.php'; ?>
</body>
</html>