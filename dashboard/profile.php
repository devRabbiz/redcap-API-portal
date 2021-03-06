<?php
require_once("../models/config.php");

if(isset($_REQUEST["ajax"]) && $_REQUEST["ajax"]){
  //WRITE TO API
  //ADD OVERIDE PARAMETER
  $formdata = $_POST;

  $data   = array();
  foreach($_POST as $field_name => $value){
    if($value === 0){
      $value = "0";
    }

    if($value == ""){
      $value = NULL;
    }

    $field_name = $redcap_field_map[$field_name];

    //SET IT IN THE SESSION
    $_SESSION[SESSION_NAME]["user"]->{$field_name} = $value;

    $data[] = array(
      "record"            => $_SESSION[SESSION_NAME]["user"]->id,
      "redcap_event_name" => $_SESSION[SESSION_NAME]["survey_context"]["event"],
      "field_name"        => $field_name,
      "value"             => $value,
    );
  }
  $result = RC::writeToApi($data, array("overwriteBehavior" => "overwite", "type" => "eav"));

  echo json_encode($data);
  exit;
}

//REDIRECT USERS THAT ARE NOT LOGGED IN
if(!isUserLoggedIn()) {
  $destination = $websiteUrl."login.php";
  header("Location: " . $destination);
  exit;
}else{
  //if they are logged in and active
  //find survey completion and go there?
  // GET SURVEY LINKS
  include("../models/inc/surveys.php");
}

$shownavsmore   = true;
$survey_active  = ' ';
$profile_active = ' class="active"';

$pg_title       = "Profile : $websiteName";
$body_classes   = "dashboard profile";
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
                    <h2></h2>
                  </section>
                  <div class="row">
                    <div class="col-sm-1">&nbsp;</div>
                    <div class="col-sm-10">
                      <h2>My Profile</h2>
                      <?php
                      $label_map = array();
                      $label_map["portal_nickname"]       = "Nickname";
                      $label_map["portal_middlename"]     = "Middle Name";
                      $label_map["email"]                 = "Email";
                      $label_map["portal_contact_name"]   = "Contact Name";
                      $label_map["portal_contact_phone"]  = "Contact Phone";
                      $label_map["portal_mail_street"]    = "Street Address";
                      $label_map["portal_apartment_no"]   = "Apartment/Number";
                      $label_map["city"]           = "City";
                      $label_map["state"]          = "State";
                      $label_map["zip"]            = "Zip Code";
                      
                      $profile_info     = $_SESSION["REDCAP_PORTAL"]["user"];
                      $p_joined         = Date("M d Y", strtotime($profile_info->email_verified_ts));
                      $p_pic            = (!$profile_info->portal_pic     ? "-10px -10px"    :$profile_info->portal_pic    );
                      $p_firstname      = (!$profile_info->firstname      ? "First Name"     :$profile_info->firstname      );
                      $p_lastname       = (!$profile_info->lastname       ? "Last Name"      :$profile_info->lastname       );
                     

                     $p_portal_apartment_no  = (!$profile_info->portal_apartment_no ? ""      :$profile_info->portal_apartment_no       );
                     $p_portal_mail_street   = (!$profile_info->portal_mail_street  ? ""      :$profile_info->portal_mail_street        );
                     $p_city                 = (!$profile_info->city                ? ""      :$profile_info->city                      );
                     $p_state                = (!$profile_info->state               ? ""      :$profile_info->state                     );
                     $p_zip                  = (!$profile_info->zip                 ? ""      :$profile_info->zip                       ); 
                      ?>
                      <style>
                      .profile_card figure span { 
                        background:url(images/profile_icons.png) <?php echo $p_pic; ?> no-repeat;
                      }
                      </style>
                      <form class="customform">
                        <div class="profile_card">
                        <figure>
                          <span id="ppic"></span>
                          <figcaption>
                            <b><?php echo $p_firstname . " " . $p_lastname ?></b>
                            <em>Joined : <?php echo $p_joined ?></em>
                          </figcaption>
                        </figure>
                        <ul>
                          <?php
                          $html         = "";
                          foreach($label_map as $item => $field_label){
                            $field_name = $redcap_field_map[$item];
                            $value      = $_SESSION["REDCAP_PORTAL"]["user"]->{$item};
                            $validate   = ($item == "email" ? 'data-validate="email"' : '');
                            $validate   = ($item == "portal_contact_phone" ? 'data-validate="phone"' : $validate);
                            $html .= "<li class='$field_name'>\n";
                            $html .= "<input $validate type='text' id='$field_name' name='$item' value='$value' placeholder='$field_label'/>\n";
                            $html .= "</li>\n";
                            if($item == "portal_contact_phone"){
                              break;
                              //DO THE REST BY HAND , UGH
                            }
                          }
                          print $html;
                          ?>
                          <li>
                          <input type="text" id="portal_mail_street" name="portal_mail_street" value="<?php echo $p_portal_mail_street ?>" placeholder="Street Address">
                          / <input type="text" id="portal_apartment_no" name="portal_apartment_no" value="<?php echo $p_portal_apartment_no ?>" placeholder="Apt No.">
                          </li>
                          <li>
                            <input type="text" id="portal_city" name="portal_city" value="<?php echo $p_city ?>" placeholder="City">
                            , <input type="text" id="portal_state" name="portal_state" value="<?php echo $p_state ?>" placeholder="State">
                            <input data-validate="number" type="text" id="portal_zip" name="portal_zip" value="<?php echo $p_zip ?>" placeholder="Zip Code">
                          </li>
                        </ul>

                        <a href="#" class="btn btn-large block btn-info editprofile">Edit Profile</a>
                        </div>
                      </form>
                    </div>
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
<div id="picpick">
  <h3>Pic Picker - Click on a Face</h3>
  <img src="images/profile_icons.png"/>
</div>
<script>
function saveFormData(elem){
  var dataDump = "profile.php?ajax=1";

  if(!elem.val()){
    elem.val(null);
  }

  $.ajax({
    url:  dataDump,
    type:'POST',
    data: elem.serialize(),
    success:function(result){
      console.log("Data Saved",result);
      
      //REMOVE THE SPINNER
      setTimeout(function(){
        $(".hasLoading").removeClass("hasLoading");
      },250);
    }
  });
}

$(document).ready(function(){
  //INPUT CHANGE ACTIONS
  $(".customform :input").change(function(){
    //SAVE JUST THIS INPUTS DATA
    $(this).closest("li").addClass("hasLoading");
    saveFormData($(this));
  }); 

  //EDIT
  $(".editprofile").click(function(){
    $(".profile_card").toggleClass("editmode");
    if($(".profile_card").hasClass("editmode")){
      $(".profile_card input").first().focus();    
    }else{
      $(".profile_card input").first().blur(); 
    }
    return false; 
  });

  //THE PROFILE PIC PICKER
  $("#ppic").click(function(){
    $("#picpick").show();
    return false;
  });

  function closest(arr, closestTo){
      var closest = Math.max.apply(null, arr); //Get the highest number in arr in case it match nothing.
      for(var i = 0; i < arr.length; i++){ //Loop the array
          if(arr[i] >= closestTo && arr[i] < closest) closest = arr[i]; //Check if it's higher than your number, but lower than your closest value
      }
      return closest; // return the value
  }

  var xar = [113, 330, 547, 764, 981];
  var yar = [150, 417, 680, 935];
  $("#picpick").click(function(e) {
    var offset = $(this).offset();
    var relativeX = (e.pageX - offset.left);
    var relativeY = (e.pageY - offset.top);
    relativeX     = 105 - closest(xar,relativeX);
    relativeY     = 140 - closest(yar,relativeY);
    var picpos    = relativeX+"px "+relativeY+"px";
    var picpos_sm = Math.round(relativeX/4.6)+"px "+Math.round(relativeY/4.6)+"px";
    var picpos_xs = Math.round(relativeX/6)+"px "+Math.round(relativeY/6)+"px";
    var imp       = $("<input>").attr("name","portal_pic");
    imp.val(picpos);

    $("#ppic").css("background-position",picpos);

    $(".thumb.avatar").css("background-position",picpos_sm);
    $(".thumb-sm.avatar").css("background-position",picpos_xs);

    $(this).hide();
    // console.log(picpos);
    saveFormData(imp);
  });

  $(document).on('click', function(event) {
    if (!$(event.target).closest('#picpick').length && $("#picpick").is(":visible")) {
      setTimeout(function(){
        $("#picpick").hide(100,function(){});
      }, 300);
    }
  });
});
</script>
