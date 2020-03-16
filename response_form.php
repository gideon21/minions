<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
?>

<!-- InstanceBegin template="/Templates/dating.dwt.php" codeOutsideHTMLIsLocked="false" --><?php include("includes/header_inc.php"); ?>
<?php include("includes/navigation_inc.php"); ?>
    
    
    <div id="main">
    
      <!-- InstanceBeginEditable name="content" -->
	  
 <h3>SoleMates - View Profile</h3>

<?php
require_once("includes/connectvars_inc.php");
 // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // If this user has never answered the questionnaire, insert empty responses into the database
  $query = "SELECT * FROM response WHERE member_id = '" . $_SESSION['user_id'] . "'";
  $data = mysqli_query($dbc, $query);
  
  if (mysqli_num_rows($data) == 0) {
    // First grab the list of topic IDs from the topic table
    $query = "SELECT topic_id FROM topic ORDER BY cat_id, topic_id";
    $data = mysqli_query($dbc, $query);
    $topicIDs = array();
    while ($row = mysqli_fetch_array($data)) {
      array_push($topicIDs, $row['topic_id']);
    }

    // Insert empty response rows into the response table, one per topic
    foreach ($topicIDs as $topic_id) {
      $query = "INSERT INTO response (member_id, topic_id) VALUES ('" . $_SESSION['user_id']. "', '$topic_id')";
      mysqli_query($dbc, $query);
    }
  }

  // If the questionnaire form has been submitted, write the form responses to the database
  if (isset($_POST['submit'])) {
    // Write the questionnaire response rows to the response table
    foreach ($_POST as $response_id => $response) {
      $query = "UPDATE response SET response = '$response' WHERE response_id = '$response_id'";
      mysqli_query($dbc, $query);
    }
    echo '<p>Your responses have been saved.</p>';
  }

  // Grab the response data from the database to generate the form
  $query = "SELECT mr.response_id, mr.topic_id, mr.response, mt.name AS topic_name, mc.name AS category_name " .
    "FROM response AS mr " .
    "INNER JOIN topic AS mt USING (topic_id) " .
    "INNER JOIN category AS mc USING (cat_id) " .
    "WHERE mr.member_id = '" . $_SESSION['user_id'] . "'";
  $data = mysqli_query($dbc, $query);
  $responses = array();
  while ($row = mysqli_fetch_array($data)) {
    array_push($responses, $row);
  }

  mysqli_close($dbc);

  // Generate the questionnaire form by looping through the response array
  echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
  echo '<p>How do you feel about each topic?</p>';
  $category = $responses[0]['category_name'];
  echo '<fieldset><legend>' . $responses[0]['category_name'] . '</legend>';
  foreach ($responses as $response) {
    // Only start a new fieldset if the category has changed
    if ($category != $response['category_name']) {
      $category = $response['category_name'];
      echo '</fieldset><fieldset><legend>' . $response['category_name'] . '</legend>';
    }

    // Display the topic form field
    echo '<label ' . ($response['response'] == NULL ? 'class="error"' : '') . ' for="' . $response['response_id'] . '">' . $response['topic_name'] . ':</label>';
    echo '<input type="radio" id="' . $response['response_id'] . '" name="' . $response['response_id'] . '" value="1" ' . ($response['response'] == 1 ? 'checked="checked"' : '') . ' />Love ';
    echo '<input type="radio" id="' . $response['response_id'] . '" name="' . $response['response_id'] . '" value="2" ' . ($response['response'] == 2 ? 'checked="checked"' : '') . ' />Hate<br />';
  }
  echo '</fieldset>';
  echo '<input type="submit" value="Save Questionnaire" name="submit" />';
  echo '</form>';

?>


	  <!-- InstanceEndEditable -->    
	  </div>
      
<?php include("includes/footer_inc.php"); ?>
<!-- InstanceEnd -->