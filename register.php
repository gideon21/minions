 <?php
    include("includes/header_inc.php"); //bring in the CSS etc
	include("includes/navigation_inc.php"); 
?>     
    
   
<h2>Join the cause fellow minions</h2>
       
<?php 
	     require_once('includes/connectvars_inc.php');
	    $dbc = mysqli_connect(localhost, root, password, goshobowale);
  	if (isset($_POST['submit'])) {
    // Grab the profile data from the POST super global, while making sure no nasty inputs get through to the database
   	 	$minionname = mysqli_real_escape_string($dbc, trim($_POST['minionname']));
    	$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    	$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

    if (!empty($minionname) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM minionmates WHERE minion_name = '$minionname'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO minionmates (minion_name, password, recruited) VALUES ('$minionname', sha1('$password1'), now())";
        mysqli_query($dbc, $query);

        // Confirm success with the user, not forgetting to use slashes to escape the apostrophies in the English
        echo '<p>Your new account has been successfully created. You\'re now ready to take over the world and
		<a href="login.php">log in </a>.</p>';

       // mysqli_close($dbc);   
      }
      else {
        // An account already exists for this username, so display an error message and persuade the minion to choose a different name
        echo '<p class="error">An account already exists for this username. Please use a different address.</p>';
        $username = "";
      }
    }
    else {//another helpful message
      echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
    }
  }
 mysqli_close($dbc);
 
?>

  <h3>Please enter your username and desired password to sign up to minion Mates.</h3>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Registration Info</legend>
      <label for="username">Minion Name:</label>
      <input type="text" id="minionname" name="minionname" value="<?php if (!empty($minionname)) echo $minionname; ?>" /><br />
      <label for="password1">Password:</label>
      <input type="password" id="password1" name="password1" /><br />
      <label for="password2">Password (retype):</label>
      <input type="password" id="password2" name="password2" /><br />
    </fieldset>
    <input type="submit" value="Join Up" name="submit" />
  </form>

<?php include("includes/footer_inc.php"); ?>