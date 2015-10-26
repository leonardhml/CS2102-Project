<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<?php include 'layout/config.php'; ?>
<?php include 'layout/layout-head.php'; ?>
<body>
<?php include 'layout/layout-header.php'; ?>

<section id="main-slider" class="no-margin">
    <div class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#main-slider" data-slide-to="0" class="active"></li>
            <li data-target="#main-slider" data-slide-to="1"></li>
            <li data-target="#main-slider" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div style="background-image: url(img/slides/9.jpg)" class="item active">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="carousel-content centered">
                                <h2 class="animation animated-item-1">SteFund</h2>
                                <p class="animation animated-item-2">Where Your Dreams Come True!</p>
                                <div id="dest-box" class="animation animated-item-3">
                                    <form action="projects.php" method="POST" class="form-dest">
                                        <div class="form-group">
                                            <input id="destinput" type="text" value="" name="projTitle" placeholder="Search for a Project" autofocus="autofocus" class="form-control col-md-10 home-input"/>
                                            <button type="submit" class="btn btn-primary btn-wm col-md-2 pull-right">Enter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.item-->
            <div style="background-image: url(img/slides/7.jpg)" class="item">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="carousel-content center centered">
                                <h2 class="animation animated-item-1">Just Do It</h2>
                                <p class="animation animated-item-1">Make Your Dreams Come True</p>
                                <br/><a href="/Comparison" class="btn btn-md animation animated-item-3">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.item-->
            <div style="background-image: url(img/slides/8.jpg)" class="item">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="carousel-content centered">
                                <h2 class="animation animated-item-1">Everyone, Get In Here</h2>
                                <p class="animation animated-item-2"></p><br/><a href="/Comparison" class="btn btn-md animation animated-item-3">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.item-->
        </div>
        <!-- /.carousel-inner-->
    </div>
    <!-- /.carousel--><a href="#main-slider" data-slide="prev" class="prev hidden-xs"><i class="icon-large icon-chevron-left"></i></a><a href="#main-slider" data-slide="next" class="next hidden-xs"><i class="icon-large icon-chevron-right"></i></a>
</section>
<!-- /#main-slider-->
<section>
    <div id="tagcloud">
        <div style="width: 400px;">
            <?php
              
                //include("TagManager.class.php");
                // prepare the tag cloud array for display

                $sql = "SELECT tag, COUNT(*) AS count FROM proposed_project GROUP BY tag";
                $res = oci_parse($dbh, $sql);
                oci_execute($res, OCI_DEFAULT);
                $tags = array(); // create empty array
                $maximum = 10; // $maximum is the highest counter for a search term

                //$row_array = array();
                while ($row = oci_fetch_array($res)) {
                    $row_array['TAG']= $row['TAG'];
                    $row_array['COUNT'] = $row['COUNT'];

                    // update $maximum if this term is more popular than the previous terms
                    if ($row_array['COUNT'] > $maximum) $maximum = $row_array['COUNT'];

                    //$tags[] = array('TAG' => $tag, 'COUNT' => $counter);
                    array_push($tags, $row_array);
                }

                // shuffle terms unless you want to retain the order of highest to lowest
                shuffle($tags); 


/*                $tags = new TagManager();
                
                $maxCount = NULL;
                $minCount = NULL;
                foreach($tags as $tag)
                {
                  $maxCount = ($tag->Count > $maxCount) ? $tag->Count : $maxCount;
                  $minCount = ($tag->Count < $minCount || $minCount == NULL) ? $tag->Count: $minCount;
                }*/
                
/*                foreach($tags as $tag)
                {
                  if($tag->Count == $maxCount) $class = 'largeTag';
                  else if($tag->Count >= ($maxCount/3)) $class = 'mediumTag';
                  else $class = 'smallTag';
                    echo '<span class="'. $class .'">
                        <a href="#">'. $tag->name .'</a>
                       </span>';
                }*/

/*                foreach($tags as $tag) {
                    if($tag->count == $maxCount) $class = ’largeTag’;
                    else if($tag->count >= ($maxCount/3)) $class = ’mediumTag’;
                    else $class = ’smallTag’;
                    echo ’<span class="’. $class .’">

                        <a href="#">’. $tag->name .’</a>
                    </span>’;
                }*/
                // start looping through the tags
                foreach ($tags as $tag):
                    // determine the popularity of this term as a percentage
                    $percent = floor(($tag['COUNT'] / $maximum) * 100);

                    // determine the class for this term based on the percentage
                    if ($percent < 20):
                        $class = 'smallest';
                    elseif ($percent >= 20 and $percent < 40):
                        $class = 'small';
                    elseif ($percent >= 40 and $percent < 60):
                        $class = 'medium';
                    elseif ($percent >= 60 and $percent < 80):
                        $class = 'large';
                    else:
                        $class = 'largest';
                    endif;
            ?>
            <span class="<?php echo $class; ?>">
                <a href="#"><?php echo $tag['TAG']; ?></a>
            </span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div class="section section-white">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="service-wrapper">
                    <h3>Top 10 Projects</h3>
                    <table class="table table-bordered" id="top10projects">
                        <thead>
                        <tr><th style="text-align: center">No. </th>
                            <th style="text-align: center">Project Title</th>
                            <th style="text-align: center">Rating</th>
                            <th style="text-align: center">View</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT title, in_charge, to_char(rating, '0.99') FROM top_projects ORDER BY rating DESC";
                        $res = oci_parse($dbh, $query);
                        oci_execute($res);
                        $i = 1;

                        while (($row = oci_fetch_array($res, OCI_BOTH)) && $i<11) {
                            $title = $row[0];
                            $inCharge = $row[1];
                            $rating = $row[2];
                            echo "<tr id='row".$i."'><td>".$i.".</td><td><input type='hidden' value='".$title."' name='Title' />".$title."</td><td><input type='hidden' value='".$inCharge."' name='In Charge' />".$rating."</td><td><button onclick=\"submitRowAsForm('row".$i."')\">View</button></td></tr>";
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                   </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="service-wrapper"><img src="img/uber.png" alt="Uber"/>
                    <h3>Taxi Booking via Uber</h3>
                    <p>Enjoy on demand rides! Transportation in minutes from airports all around the world to your destination doorstep.</p><a href="/UberTaxi" class="btn">Read more</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="service-wrapper"><img src="img/skyscanner.png" alt="skyscanner"/>
                    <h3>Car Rental via Skyscanner</h3>
                    <p>Hit the road right after your flight! Enjoy premium services at discounted price! Only availble to Krisflyer members</p><a href="/skyscanner" class="btn">Read more</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script async="async" defer="defer" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfNGAOsA5M5843fJto87OHwKjUAiGIGiE&amp;libraries=places&amp;callback=initialize"></script>
<script type="text/javascript" src="js/homepage.js"></script>

<?php include 'layout/layout-footer.php'; ?>
<?php include 'layout/layout-scripts.php'; ?>

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
</body>
</html>