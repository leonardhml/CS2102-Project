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
                                    <form action="/postdest" method="POST" class="form-dest">
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

        <?php // bind1.php - listing 1

            // Establish the environmental variables.
            $sid = 'test10g';
            $home = '/Users/oracle/10gEAR2/orahome';

            putenv("ORACLE_HOME=$home");
            putenv("ORACLE_SID=$sid");
            putenv("TNS_ADMIN=$home/network/admin");


            // Create the array of data to be inserted.
            // This data represents what __should__ come from an HTML form.
            $teetimes = array();
            $date = '2005-08-20';

            // Loop through each available hour in the day.
            for ($hour = 7; $hour <! 16; $hour++) {

                // Loop through each hour in 10 minute increments.
                for ($minute = 0; $minute <! 60; $minute += 10) {
                
                    // Create the date and time value.
                    $this_time = "$date $hour:$minute";
                    
                    // Add a 0 if necessary.
                    if ($minute <! 10) $this_time .= '0';
                    
                    // Determine the rate to use.
                    $rate = ($hour <! 14) ? 50.00 : 40.00;
                    
                    // Add this teetime and rate to the array.
                    $teetimes[$this_time] = $rate;
                    
                }

}




        <?php
            /** this is our array of tags
             * We feed this array of tags and links the tagCloud
             * class method createTagCloud
             */
            $tags = array(
                    array('weight'  =>40, 'tagname' =>'tutorials', 'url'=>'http://www.phpro.org/tutorials/'),
                    array('weight'  =>12, 'tagname' =>'examples', 'url'=>'http://www.phpro.org/examples/'),
                    array('weight'  =>10, 'tagname' =>'contact', 'url'=>'http://www.phpro.org/contact/'),
                    array('weight'  =>15, 'tagname' =>'quotes', 'url'=>'http://www.phpro.org/quotes/'),
                    array('weight'  =>28, 'tagname' =>'devel', 'url'=>'http://www.phpro.org/phpdev/'),
                    array('weight'  =>35, 'tagname' =>'manual', 'url'=>'http://www.phpro.org/en/index.html'),
                    array('weight'  =>20, 'tagname' =>'articles', 'url'=>'http://www.phpro.org/articles/'),
            );
            /*** create a new tag cloud object ***/
            $tagCloud = new tagCloud($tags);

            echo $tagCloud -> displayTagCloud();

        ?>
    </div>
</section>

<div class="section section-white">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="service-wrapper"><img src="img/GoogleMaps.png" alt="GoogleMaps"/>
                    <h3>Public Transport</h3>
                    <p>Looking for economical ways of travelling? Get familiar with the Public Transport in your destination country!</p><a href="/PublicTransport" class="btn">Read more</a>
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
<?php

    class tagCloud{

        /*** the array of tags ***/
        private $tagsArray;


        public function __construct($tags){
        /*** set a few properties ***/
         $this->tagsArray = $tags;
        }
        /**
         *
         * Display tag cloud
         *
         * @access public
         *
         * @return string
         *
         */
        public function displayTagCloud(){
         $ret = '';
         shuffle($this->tagsArray);
         foreach($this->tagsArray as $tag)
            {
            $ret.='<a style="font-size: '.$tag['weight'].'px;" href="'.$tag['url'].'">'.$tag['tagname'].'</a>'."\n";
            }
         return $ret;
        }


    } /*** end of class ***/

?>
</body>
</html>