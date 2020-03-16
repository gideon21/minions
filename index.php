<?php
    require_once("includes/start_Session_inc.php"); // Very important for the login part
    include("includes/header_inc.php");  //Now includes database connection to be tidy
    include("includes/navigation_inc.php"); // Dynamic navigation included here
?>

<div id="main">

<?php
  // Connect to the database
  require_once("includes/connectvars_inc.php");
  //echo DB_HOST, DB_USER ,DB_PASSWORD, DB_NAME;
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Retrieve the user data from MySQL - This can be tested in PHP my admin before you hardcode it
  $query = "SELECT minion_id, minion_name, picture FROM minionmates WHERE minion_name IS NOT NULL ORDER BY recruited DESC LIMIT 10";
  // Pay attention to the syntax and structure, this is easily modified

  $data = mysqli_query($dbc, $query);
  //Run the query!

  // Loop through the array of user data, formatting it as HTML
  echo '<h3>Latest members:</h3>';

 //Start the HTML for a table, but outside of the main loop that brings the results back from the database
  echo '<table>';

  while ($row = mysqli_fetch_array($data)) {
    if (is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) {
      echo '<tr><td><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['minion_name'] . '" /></td>';
    }// So if we can find a minion Record, their mugshot will be shown by default
    else
    {
      echo '<tr><td><img src="' . MM_UPLOADPATH . 'default_gru.gif' . '" alt="' . $row['minion_name'] . '" /></td>';
    }// This bit of code puts in a default image if there is no profile picture

    if (isset($_SESSION['minion_id']))
    {
      echo '<td><a href="minion_profile.php?minion_id=' . $row['minion_id'] . '">' . $row['minion_name'] . '</a></td></tr>';
    }// If we are logged in, this generates a clickable link that takes you through to their edit profile page
    else
    {
    echo '<td>' . $row['minion_name'] . '</td></tr>';//Shows you the minion name
  }
  }
  echo '</table>';


  mysqli_close($dbc);

?>

</div>

<?php include("includes/footer_inc.php"); ?>
