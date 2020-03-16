<?php 
require_once("includes/start_session_inc.php"); // Start the session
include("includes/header_inc.php"); 
include("includes/navigation_inc.php"); ?>

<div id="main">
    
<?php
	require_once("includes/connectvars_inc.php");

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Grab the profile data from the database
  
  if (!isset($_GET['minion_id'])) {
    $query = "SELECT minion_name,  code_name, cloned, recruited,location, picture FROM minionmates WHERE minion_id = '". $_SESSION['minion_id'] . "'";
  }
  else {
    $query = "SELECT minion_name,  code_name, cloned, recruited,location, picture FROM minionmates  WHERE minion_id = '" . $_GET['minion_id'] . "'";
  }
  
  $data = mysqli_query($dbc, $query);

  if (mysqli_num_rows($data) == 1) {
    // The user row was found so display the user data
    	$row = mysqli_fetch_array($data);
    
		echo '<table>';
		if (!empty($row['minion_name'])) 
			{
      	echo '<tr><td class="label">Minion name:</td><td>' . $row['minion_name'] . '</td></tr>';
    	}
		if (!empty($row['cloned'])) 
		{
      	echo '<tr><td class="label">Cloned:</td><td>' . $row['cloned'] . '</td></tr>';
    	}
	
	  	if (!empty($row['code_name'])) 
		{
      	echo '<tr><td class="label">Code name:</td><td>' . $row['code_name'] . '</td></tr>';
    	}
	  	if (!empty($row['location'])) 
		{
      	echo '<tr><td class="label">Location:</td><td>' . $row['location'] . '</td></tr>';
    	}
    	if (!empty($row['picture'])) {
      		echo '<tr><td class="label">Picture:</td><td><img src="' . MM_UPLOADPATH . $row['picture'] .
        	'" alt="Profile Picture" /></td></tr>';
    	}
			if (!empty($row['recruited'])) 
		{
      	echo '<tr><td class="label">Recruited:</td><td>' . $row['recruited'] . '</td></tr>';
    	}
    echo '</table>';	
	}
	
	//echo $_SESSION['minion_id'];
	//echo $_GET['minion_id'];
	
   if (isset($_GET['minion_id']) || ($_SESSION['$minion_id'] == $_GET['minion_id'])) 
   	{
      echo '<p>Would you like to <a href="edit_profile.php">edit your profile</a>?</p>';
    }
 // End of check for a single row of user results
  	else
  	{
    echo '<p class="error" >There was a problem accessing your profile minion ' . $_SESSION['minion_name'] .  '.</p>';
  	}
  mysqli_close($dbc);
  
?>
<?php include("includes/footer_inc.php"); ?>