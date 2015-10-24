<!DOCTYPE html>
<html>
<?php include 'layout/config.php'; ?>
<?php include 'layout/layout-head.php'; ?>
<head>
    <?php include 'layout/layout-scripts.php'; ?>

</head>
<body>
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
                <input id="projTitle" type="text" value="" name="projTitle" placeholder="Search for a Project" autofocus="autofocus" class="form-control col-md-10 home-input"/>

                <button type="submit" class="btn btn-primary btn-wm col-md-2 pull-right">Enter</button>
            </div>
        </form>
        <button type="button" id="test">test me</button>
    </div>
    <div class="container">
        <table class="table table-bordered" id="projectsTable">
        </table>
    </div>
</div>
<script type="text/javascript">
    $("document").ready(function(event){
        $("#test").click(function() {
            alert("jqueryworks");
        });
        $(".form-dest").submit(function(){
            var dataString = $(this).serialize();
            $.post('getProjectsJSON.php', dataString, function(data) {
                var table = buildTable(data);

                $("#projectsTable").html(
                    table
                );

                function buildTable(data) {
                    alert(data);
                    var dataJSON = jQuery.parseJSON(data);
                    var tmp = "<thead><tr>";
                    for (var header in dataJSON[0] ) {
                        tmp = tmp + "<th>" + header + "</th>";
                    }
                    tmp = tmp + "</tr></thead>";
                    tmp = tmp + "<tbody>";
                    for (var i = 0; i<dataJSON.length;i++) {
                        var obj = dataJSON[i];
                        tmp = tmp + "<tr>";
                        for(var header in obj) {
                            tmp=tmp+"<td>"+obj[header]+"</td>";
                        }
                        tmp = tmp + "</tr>";
                    }
                    tmp = tmp + "</tbody>";
                    alert(tmp);
                    return tmp;
                }

            });

            return false;
        });
    });
</script>
<?php include 'layout/layout-footer.php'; ?>
</body>
</html>