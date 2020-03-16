<?php
//this is where the data goes from
require_once("includes/start_Session_inc.php"); // Start the session
require_once('includes/connectvars_inc.php');

// create an empty variable to contain any error messages
$error_msg = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['minion_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      // Grab the user-entered log-in data from the form, clean it up and put into  new variables to feed into your query below
      $minion_name = mysqli_real_escape_string($dbc, trim($_POST['minion_name']));
      $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($minion_name) && !empty($password)) {
        // Look up the minion_name and password in the database - Note the SHA1 encryption on the password to check against the stored encrypted value
        $query = "SELECT minion_id, minion_name, password FROM minionmates WHERE minion_name = '$minion_name' AND password = sha1('$password')";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          // The log-in is OK so set the user ID and minion_name session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
          $_SESSION['minion_id'] = $row['minion_id'];
          $_SESSION['minion_name'] = $row['minion_name'];
          setcookie('minion_id', $row['minion_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('minion_name', $row['minion_name'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
        }
         else {
// The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid username and password to log in.'  ;
        }
      }
      else {
        // The username/password weren't entered so set an error message;
        $error_msg = 'Sorry, you must enter your username and password to log in, OK.'. $minion_name . $password ;
      }
    }
  }

?>

<!--this is all the page output code -->

<?php

    include ('includes/header_inc.php');
    include ('includes/navigation_inc.php');
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['minion_id'])) {
    echo '<p class="error">' . $error_msg . '</p>';
?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Log In</legend>
      <label for="username">Minion Name:</label>
      <input type="text" name="minion_name" value="<?php if (!empty($minion_name)) echo $minion_name; ?>" /><br />
      <label for="password">Password:</label>
      <input type="password" name="password" />
    </fieldset>
    <input type="submit" value="Log In" name="submit" />
  </form>

<?php
  }
  else {
    // Confirm the successful log-in
        echo('<p class="login">You are logged in as ' . $_SESSION['minion_name'] .  '. <a href="logout.php">Log out</a>.</p>');
  }
?>
<?php include("includes/footer_inc.php"); ?>
