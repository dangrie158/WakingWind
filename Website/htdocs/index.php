<?php
  session_start();
  include 'connect/connect.php';
  include 'functions/onlinestatus.php';
  
  $menu = array(
  	'home'=>array('id'=>0, 'title'=>'Home', 'module'=>'home.php', 'showInMenu'=>true ),
	'statistics'=>array('id'=>1, 'title'=>'Data Statistics', 'module'=>'statistics.php', 'showInMenu'=>true ),
	'export'=>array('id'=>2, 'title'=>'Export Widget', 'module'=>'export.php', 'showInMenu'=>false ),
	'register'=>array('id'=>3, 'title'=>'Register', 'module'=>'register.php', 'showInMenu'=>false),
	'login'=>array('id'=>4, 'title'=>'Login', 'module'=>'login.php', 'showInMenu'=>false)
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
  <link rel="stylesheet" media='screen and (max-width: 950px) and (min-width: 750px)' href="css/med.css" type="text/css" />
  <link rel="stylesheet" media='screen and (max-width: 750px)' href="css/small.css" type="text/css" />
  <link rel="stylesheet" media='screen and (max-device-width: 480px)' href="css/mobile.css" type="text/css" />
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />
  <link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" />
	<style type="text/css">
			body{
			background: url(images/<?php echo $selectedBg; ?>) no-repeat;
			background-size:100%;
			background-attachment:fixed;
			}
		
		@media handheld and (max-width: 950px) {
			body{
			background: url(images/m<?php echo $selectedBg; ?>) no-repeat;
			background-size:100%;
			background-attachment:fixed;
			
			}
		}
	</style> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="js/login.js"></script>
    <script>
  		$(function() {
		    var locations = [
		    	<?php
		    		$sql = "SELECT id, loc_name, loc_address FROM locations";
		    		$result = mysql_query( $sql );
		    		$i = 0;
		    		while( $row = mysql_fetch_assoc( $result ) )
		    		{
		    			if( $i++ != 0 )
		    				echo ",";
		    			echo "{id:'". $row['id'] ."', label:'". $row['loc_name'] .", ". $row['loc_address'] ."', online:'". loc_online( $row['id'] ) ."'}";
		    		}

		    	?>
		    ];
		 
		    var searchBox = $( "#searchbox" ).autocomplete({
		      minLength: 0,
		      source: locations,
		      focus: function( event, ui ) {
		        $( "#searchbox" ).val( ui.item.value );
		        return false;
		      },
		      select: function( event, ui ) {
		        $( '#search_id' ).val( ui.item.id );
		        return false;
		      }
		    });
		    searchBox.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				if( item.online != '' )
				{
						return $( "<li>" )
			        .append( '<a>' + item.label + '<br /><em style="color:green;">last updated: ' + item.online + '</em></a>' )
			        .appendTo( ul );
			    }else
			    {
			      		return $( "<li>" )
			        .append( '<a>' + item.label + '<br /><em style="color:red;">offline</em></a>' )
			        .appendTo( ul );
			    }
		    };
		});
	</script>
    
</head>
<body>
	<header>
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
						  echo '<li '. $isActive .'><a href="?site='. $key .'">'. $value['title'] .'</a> </li>';
					  }
				  }
			  	?>
	      	</ul>
	    </nav>
	    	<div id="loginContainer">
	    <?php 
	    	if( isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true )
	    	{
	    ?>
	    		<a href="/modules/login.php?loginaction=logout" id="logoutbutton"><span>Logout</span></a>
            	<div style="clear:both"></div>
	    <?php
	    	}else{
	    ?>
                <a href="#" id="loginButton"><span>Login</span><em></em></a>
                <div style="clear:both"></div>
                <div id="loginBox">                
                    <form id="loginForm" method="post" action="/modules/login.php?loginaction=login">
                        <fieldset id="body">
                            <fieldset>
                                <label for="EMail">Email Address</label>
                                <input type="text" name="EMail" id="email" />
                            </fieldset>
                            <fieldset>
                                <label for="Password">Password</label>
                                <input type="password" name="Password" id="password" />
                            </fieldset>
                            <input type="submit" id="login" value="Sign in" />
                        </fieldset>
                        <span><a href="?site=register">Sign up!</a></span>
                    </form>
                </div>
            <?php
            	}
            ?>
            </div>
           	<form method="get" action="?site=home" id="search">
 				<input id="searchbox" name="query" type="text" size="40" placeholder="Search for Locations..." />
                <input id="search_id" name="locid" type="hidden" />
			</form>
	</header>
    <?php
		include( "modules/". $selectedMenu['module'] );
	?>
</body>
</html>