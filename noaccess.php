<?php require_once("includes/start_session_inc.php"); 
include("includes/header_inc.php"); 
include("includes/navigation_inc.php");
?>    
    
    
 <?php // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['minion_id'])) {
  
  	echo '<h2>ACCESS DENIED</h2>';
	
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }
  else {
    echo('<p class="login">You are logged in as ' . $_SESSION['minion_name'] . '. <a href="logout.php">Log out</a>.</p>');
	echo('<p>You are more than welcome to be here, as this site is secured by sessions and cookies<p>
		<p>Even if you accidentally close your browser, the cookie should let you back in until you <strong>logout</strong></p>');
  }
	
?>
<?php include("includes/footer_inc.php"); ?>