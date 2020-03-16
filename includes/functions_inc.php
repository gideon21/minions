
<?php


 // SQL injection protection function - useful for logins
 
function mysql_entities_fix_string($string) {
	return htmlentities(mysql_fix_string($string));
}

 //html hack protection function - useful for text entry boxes

function mysql_fix_string($string) {
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return mysql_real_escape_string($string);
}


session_start();
  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
  
define ('AA_UPLOADPATH' , 'uploads/');   //defining a constant to use on any of our pages
  // Define database connection constants
  //define('DB_HOST', 'localhost');
  //define('DB_USER', 'goshobowale');
  //define('DB_PASSWORD', 'zNxj3Afa');
  //define('DB_NAME', 'goshobowale');

// my laptop on xampp
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'minionmates');

?>


?>