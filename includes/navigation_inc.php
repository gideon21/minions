  <div id="nav_top">
      <ul>
        <li><a href="index.php" id="home" >Home </a></li>      
        <li><a href="login.php" id="log">Login</a></li>
        <?php
		if (!isset($_SESSION['minion_id'])) { 
		echo '<li><a href="register.php" id="sign">Join the cause</a></li>
		';
		}
		?>
        
        <li><a href="noaccess.php" id="log">Denied Access</a></li>
        <?php
		if (isset($_SESSION['minion_id'])) { 
			echo '<li><a href="logout.php" id="matchup">Dynamic Logout link based on being logged in</a></li>
			';
		}

		?>

  	</ul>
    </div>