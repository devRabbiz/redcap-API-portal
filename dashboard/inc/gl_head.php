<?php
/*
RedcapPortalUser Object
(
    [user_id] => 2  //RECORD ID ALSO
    [username] => buspo@giants.com
    [firstname] => buster
    [lastname] => posey
    [zip] => 94022
    [city] => los altos
    [state] => ca
    [age] => 24
)
*/ 

$firstname  = $loggedInUser->firstname;
$lastname   = $loggedInUser->lastname;
$city       = $loggedInUser->city;
$state      = $loggedInUser->state;
$location   = $city . "," . $state;
?>
<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title><?php echo $pg_title ?></title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="css/animate.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/icon.css" type="text/css" />
  <link rel="stylesheet" href="css/font.css" type="text/css" />
  <link rel="stylesheet" href="css/app.css" type="text/css" />  
  <link rel="stylesheet" href="js/calendar/bootstrap_calendar.css" type="text/css" />

  <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.3/themes/ui-lightness/jquery-ui.css"/>
  <link rel="stylesheet" href="css/weather.css" />
  <link rel="stylesheet" type="text/css" href="css/custom.css"/>

  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body class="<?php echo $body_classes ?>">
<?php
  print getSessionMessages();
?>