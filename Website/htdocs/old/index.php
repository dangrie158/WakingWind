<?php
  include 'connect/connect.php';

  session_start();
  
  $menu = array(
  	'home'=>array(id=>0, title=>'Home', module=>'home.php', showInMenu=>true ),
	'statistics'=>array(id=>1, title=>'Data Statistics', module=>'statistics.php', showInMenu=>true ),
	'export'=>array(id=>2, title=>'Export Widget', module=>'export.php', showInMenu=>false ),
	'register'=>array(id=>3, title=>'Register', module=>'register.php', showInMenu=>true)
  );
  if($_SESSION['loggedin'] == true)
  {
  	$menu['register']['showInMenu'] = false;
  }
  $selectedMenu = $menu['home'];
  if( isset($_GET['site']) && array_key_exists($_GET['site'], $menu) )
  {
	  $selectedMenu = $menu[$_GET['site']];
  }
  
  //random background image
  $bg = array('bg_1.jpg', 'bg_2.jpg', 'bg_3.jpg'); // array of filenames normal
  $i = rand(0, count($bg)-1); // generate random number size of the array
  $selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen
?>
<!DOCTYPE html>
<html lang="de">
<head> 
  <meta charset="utf-8" />
  <title>Waking Wind - <?php echo $selectedMenu['title']; ?></title>
  <link rel="stylesheet" media='screen' href="css/main.css" type="text/css" />
  <link rel="stylesheet" media='screen and (max-width: 720px)' href="css/mobile.css" type="text/css" />
  <link rel="stylesheet" media='handheld' href="css/mobile.css" type="text/css" />
  <link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" />
	<style type="text/css">
			.randombg{
			background: url(images/<?php echo $selectedBg; ?>) no-repeat;
			background-size:100%;
			background-attachment:fixed;
			}
		
		@media only screen and (max-width: 720px) {
			.randombg{
			background: url(images/m<?php echo $selectedBg; ?>) no-repeat;
			background-size:100%;
			background-attachment:fixed;
			}
		}
		@media only screen and (max-width: 510px) {
			.randombg{
			background: url(images/m<?php echo $selectedBg; ?>) no-repeat;
			background-size:auto 100%;
			background-attachment:fixed;
			}
		}
	</style> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    
</head>
<body class="randombg">
  <div id="doc">
	  <header id="header">
	    <h1>Waking Wind</h1>
		<h2>real-time wind data from anywhere to everywhere</h2>
	    <nav>
	      <ul>
          <?php 
		  foreach( $menu as $key=>$value )
		  {
			  if( $value['showInMenu'] )
			  {
				  if( $value == $selectedMenu )
					  $isActive = 'class="active"';
				  else
					$isActive = '';
				  echo '<li '. $isActive .'> <a href="?site='. $key .'">'. $value['title'] .'</a> </li>';
			  }
		  }
		  ?>
	      </ul>
	    </nav>
	  </header>
    <?php
		include( "modules/". $selectedMenu['module'] );
	?>
      <footer>
	    <a href="#">Impressum</a>
	  </footer>
  </div>
</body>
</html>