<?
require_once("../models/config.php");

$sid              = $_GET["sid"];
$iframe_src       = "http://redcap.stanford.edu/surveys/?s=C4LCPHX4FL";
for($i = 1; $i < 6; $i++){
  $sid_class[$i] = null;
}
$sid_class[$sid ] = "class='hot'";

switch($_GET["sid"]){
  case 1:
  break;

  case 2:
  $iframe_src = "http://redcap.stanford.edu/surveys/?s=7yIVRhnMba";
  break;

  case 3:
  $iframe_src = "http://redcap.stanford.edu/surveys/?s=zXnFvdeSzI";
  break;
  
  case 4:
  $iframe_src = "http://redcap.stanford.edu/surveys/?s=8sFwdQBJ4V";
  break;
  
  case 5:
  $iframe_src = "http://redcap.stanford.edu/surveys/?s=7yIVRhnMba";
  break;
  
  default:
  
  break;
}

$navmini        = true;
$pg_title       = "Surveys : $websiteName";
$body_classes   = "dashboard survey";
include("inc/gl_head.php");
?>
  <section class="vbox">
    <?php 
      include("inc/gl_header.php"); 
    ?>
    <section>
      <section class="hbox stretch">
        <?php 
          include("inc/gl_sidenav.php"); 
        ?>

        <section id="content">
          <section class="hbox stretch">
            <section>
              <section class="vbox">
                <section class="scrollable padder">              
                  <section class="row m-b-md">
                    
                  </section>

                  <div class="row">
                    <div class="col-sm-9">
                      <iframe id="surveyFrame" frameborder="0" width="100%" height="1000" scrolling="auto" name="eligibilityScreener" 
                        src="<?php echo $iframe_src; ?>"></iframe>
                    </div>

                    <div class="col-sm-3">
                      <div class="well">
                        <h2>Survey Completion</h2>
                        <h3 class="percent_complete">0%! <span>0 of 5 complete</span></h3>
                        <div class="footer-links">
                          <ul class="surveys">
                            <li <?php echo $sid_class[1] ?>><a class=" grapes" href="survey.php?sid=1">Screening Questions for the Wellness Living Laboratory</a></li>
                            <li <?php echo $sid_class[2] ?>><a class=" apple" href="survey.php?sid=2">Socio-Demographic Questions</a></li>
                            <li <?php echo $sid_class[3] ?>><a class=" orange" href="survey.php?sid=3">Health Behavior Questions</a></li>
                            <li <?php echo $sid_class[4] ?>><a class=" cherry" href="survey.php?sid=4">Social and Neighborhood Environment</a></li>
                            <li <?php echo $sid_class[5] ?>><a class=" banana" href="survey.php?sid=5">Wellness Questions</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>           
                  
                  <div class="submits">
                    <button class="btn btn-warning">Save & Exit</button> <button class="btn btn-primary">Submit</button>
                  </div>
                </section>
              </section>
            </section>
            
            <?php
              include("inc/gl_slideout.php");
            ?>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
      </section>
    </section>
  </section>
<?php
include("inc/gl_foot.php");
?>
<script>
var ifr     = document.getElementById( "surveyFrame" );
var ifrDoc  = ifr.contentDocument || ifr.contentWindow.document;

var theForm = ifrDoc.getElementById( yourFormId );
</script>
