<?php
	session_start();
	$noNavbar = '';


	if (isset($_SESSION['Username'])) {
		header('Location: dashboard.php'); // Redirect To Dashboard Page
	}

	include 'init.php';

	// Check If User Coming From HTTP Post Request





	if ($_SERVER['REQUEST_METHOD'] == 'POST') {


		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);

		// Check If The User Exist In Database 
        

		$stmt = $con->prepare("SELECT
									UserID, Username, Password
								FROM
									users
								WHERE
									Username = ?
								AND
									Password = ?
								AND
									GroupID = 1
								LIMIT 1");

		$stmt->execute(array($username,$hashedPass));
		$row=$stmt->fetch();
		$count=$stmt->rowCount();


		// If Count > 0 This Mean The Database Contain Record About This Username

		if ($count > 0) {
            
          $_SESSION['Username'] = $username; // Register Session Name
			$_SESSION['ID'] = $row['UserID']; // Register Session ID
			header('Location: dashboard.php'); // Redirect To Dashboard Page
			exit();
		}

	}

?>

 <div class="header">
  	<h2>Admin Login</h2>
  </div>


 <form class="login " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />


  
  	<div class="input-group">
  	  <button type="submit"  class="btn"  name="Login">Login</button>
  	</div>

    
  </form>
  





<?php include $tpl . 'footer.php'; ?>
