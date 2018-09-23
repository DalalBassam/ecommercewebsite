<?php

	ob_start();
	session_start();
	$pageTitle = 'Members';
	
	if (isset($_SESSION['Username'])) {
		include 'init.php';
			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

				if ($do == 'Manage') { // Manage Members Page

					$query = ''; // RegStatus Page
					if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
						$query = 'AND RegStatus = 0';
					}


					// Select All Table Name users Except Admin
					$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
					try {
						$stmt->execute(); // Execute The Statment
						$rows = $stmt->fetchAll(); // Asign To Variable
					} catch(PDOException $e) {
						die($e->getMessage());


					}


					
					if (!empty($rows)) {



?>



<h1 class="text-center">Manage Members</h1>
				<div class="container">
				<div class="table-responsive">
		<table class="main-table text-center table table-bordered">
									<tr>
										<td>#ID</td>
										<td>Username</td>
										<td>Email</td>
										<td>Full Name</td>
										<td>Registerd Date</td>
										<td>Control</td>
									</tr>
									<?php
										foreach ($rows as $row) {
											echo '<tr>';
												echo '<td>' . $row['UserID'] . '</td>';
												echo '<td>' . $row['Username'] . '</td>';
												echo '<td>' . $row['Email'] . '</td>';
												echo '<td>' . $row['FullName'] . '</td>';
												echo '<td>' . $row['Date'] . '</td>';
												echo '<td>
														<a href="members.php?do=Edit&userid=' . $row['UserID'] . '" class="btn "><i class="fa fa-edit"></i> Edit</a>
														<a href="members.php?do=Delete&userid=' . $row['UserID'] . '" class="btn  confirm"><i class="fa fa-close"></i> Delete</a> ';

														if ($row['RegStatus'] == 0) {
															echo '<a href="members.php?do=Activate&userid=' . $row['UserID'] . '" class="btn "><i class="fa fa-close"></i> Activate</a>';
														}

												echo '</td>';
											echo '</tr>';
										}
									?>
								</table>
							</div>
							<a href="members.php?do=Add" class="btn btn-primary">
								<i class="fa fa-plus"></i> New Member
							</a>
						</div>
<?php 				} else {
						echo '<div class="container">';
							echo '<div class="nice-message">';
								echo 'There\'s No Recorde To Show';
							echo '</div>';
							echo '<a href="members.php?do=Add" class="btn btn-primary">
										<i class="fa fa-plus"></i> New Member
									</a>';
						echo '</div>';
					} 
?>
<?php

				} elseif ($do == 'Add') { // Add Members Page ?>

			<div class="container Add_Member">
                <h1 class="text-center">Add New Member</h1>
				<div class="panel">
					<div class="panel-heading">
                        Add New Member
                    </div>


						<form class="form-horizontal" action="?do=Insert" method="POST">
							<!-- Start Username Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Username</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login Into Shop" />
								</div>
							</div>
							<!-- End Username Field -->
							<!-- Start Password Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10 col-md-6">
									<input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder="Password Must Be Hard & Complex"/>
									<i class="show-pass fa fa-eye fa-2x"></i>
								</div>
							</div>
							<!-- End Password Field -->
							<!-- Start Email Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10 col-md-6">
									<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />
								</div>
							</div>
							<!-- End Email Field -->
							<!-- Start Full Name Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Full Name</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="full" class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page" />
								</div>
							</div>
							<!-- End Full Name Field -->
							<!-- Start Submit Field -->
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Add Member" class="btn btn-lg" />
								</div>
							</div>
							<!-- End Submit Field -->
						</form>
					</div>
                </div>
					</div>
            </div>
<?php
				} elseif ($do == 'Insert') { // Insert Member Page

/* End Add */
/* Start Insert*/


                    if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check Request Method

                        echo "<h1 class='text-center'>Insert Member</h1>";
                        echo "<div class='container'>";

                        // Get Variables From The Form
                        $user 	= $_POST['username'];
                        $pass 	= $_POST['password'];
                        $email 	= $_POST['email'];
                        $name 	= $_POST['full'];
                        $hashPass = sha1($_POST['password']);

                        // Validate Form
                        $formError = array();

                        if (strlen($user) < 4) {
                            $formError[] = 'Username Cant Less Than <strong>4 Characters</strong>';
                        }
                        if (strlen($user) > 20) {
                            $formError[] = 'Username Cant More Than <strong>20 Characters</strong>';
                        }
                        if (empty($user)) {
                            $formError[] = 'Username Cant <strong>Empty</strong>';
                        }
                        if (empty($pass)) {
                            $formError[] = 'Password Cant <strong>Empty</strong>';
                        }
                        if (empty($email)) {
                            $formError[] =  'Email Cant <strong>Empty</strong>';
                        }
                        if (empty($name)) {
                            $formError[] =  'Full Name Cant <strong>Empty</strong>';
                        }

                        // Loop Into Errors Array And Echo It
                        foreach ($formError as $error) {
                            echo '<div class="alert alert-danger">' . $error . '</div>';
                        }

                        // Check If There's No Error Proceed The Update Operation
                        if (empty($formError)) {

                            // Check If User Exist In Database
                            $check = checkItem("Username", "users", $user);
                            if ($check == 1) {
                                    $theMsg = "<div class='alert alert-danger'>Sorry This Username Is Exist</div>";
                                    redirectHome($theMsg, 'back');
                            } else {

                                // Insert Userinfo In Database
                                $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date) VALUES(:zuser, :zpass, :zmail, :zname, 1, now())");
                                $stmt->execute(array(':zuser' => $user, ':zpass'=> $hashPass, ':zmail'=> $email, ':zname'=> $name));

                                // Echo Success Message
                                $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Inserted </div>';
                                redirectHome($theMsg, 'back');
                            }
                        }
                    } else {
                        echo "<div class = 'container'>";

                        $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Bage Directly</div>";
                        redirectHome($theMsg, 5);

                        echo "</div>";
                    }

                    echo "</div>";

                    /*End insert*/


				} elseif ($do == 'Edit') { // Edit Members Page

					// Check If Get Request userid Is Numeric & Get Value Of It
					$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; // Security

					// Select All Data Depend On This ID
					$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1"); // LIMIT 1 ► One row

					// Execute Query
					$stmt->execute(array($userid));

					// Fetch The Data
					$row = $stmt->fetch();

					// The Row Count → if Theres Such ID Show The Form
					$count = $stmt->rowCount();

					if ($count > 0) {

?>

                        <h1 class="text-center">Edit Member</h1>
                        <div class="container">
                            <div class="Edit_Member">
                        <div class="panel">
                        <div class="panel-heading">
                            Edit Member
                        </div>

							<form class="form-horizontal" action="?do=Update" method="POST">
								<input type="hidden" name="userid" value="<?php echo $userid ?>" />
								<!-- Start Username Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Username</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="username" value="<?php echo $row['Username'] ?>" class="form-control" autocomplete="off" required="required" />
									</div>
								</div>
								<!-- End Username Field -->
								<!-- Start Password Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">New Password</label>
									<div class="col-sm-10 col-md-6">
										<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
										<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change"/>
									</div>
								</div>
								<!-- End Password Field -->
								<!-- Start Email Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Email</label>
									<div class="col-sm-10 col-md-6">
										<input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required" />
									</div>
								</div>
								<!-- End Email Field -->
								<!-- Start Full Name Field -->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Full Name</label>
									<div class="col-sm-10 col-md-6">
										<input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required" />
									</div>
								</div>
								<!-- End Full Name Field -->
								<!-- Start Submit Field -->
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" value="Save" class="btn btn-primary btn-lg" />
									</div>
								</div>
								<!-- End Submit Field -->
							</form>
						</div>
                        </div>
                        </div>
                        </div>
					
<?php
					} else { // If Theres No Such ID Show Error Message
						echo "<div class='container'>";

							$theMsg = "<div class='alert alert-danger'>Theres No Such ID</div>";
							redirectHome($theMsg);

						echo "</div>";
					}
/* End Edit */
/* Start Update */
				} elseif ($do == 'Update') { // Update Page
					
					echo "<h1 class='text-center'>Update Member</h1>";
					echo "<div class='container'>";

					if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check Request Method

						// Get Variables From The Form
						$id 	= $_POST['userid'];
						$user 	= $_POST['username'];
						$email 	= $_POST['email'];
						$name 	= $_POST['full'];


						$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

						// Validate Form
						$formError = array();

						if (strlen($user) < 4) {
							$formError[] = 'Username Cant Less Than <strong>4 Characters</strong>';
						}
						if (strlen($user) > 20) {
							$formError[] = 'Username Cant More Than <strong>20 Characters</strong>';
						}
						if (empty($user)) {
							$formError[] = 'Username Cant <strong>Empty</strong>';
						}
						if (empty($email)) {
							$formError[] =  'Email Cant <strong>Empty</strong>';
						}
						if (empty($name)) {
							$formError[] =  'Full Name Cant <strong>Empty</strong>';
						}

						// Loop Into Errors Array And Echo It
						foreach ($formError as $error) {
							echo '<div class="alert alert-danger">' . $error . '</div>';
						}
							
							if (empty($formError)) { // Check If There's No Error Proceed The Update Operation

								$stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
								$stmt2->execute(array($user, $id));
								$count = $stmt2->rowCount();

								if ($count == 1) {

									$theMsg = "<div class='alert alert-danger'>Sorry This Users Is Exist</div>";
									redirectHome($theMsg, 'back', 5);

								} else {

									$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?"); // Update The Database With This Info
									$stmt->execute(array($user, $email, $name, $pass, $id));

									$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Updated </div>'; // Echo Success Message
									redirectHome($theMsg, 'back', 5);
								}

								
							}
					} else {

						$theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Bage Directly</div>";
						redirectHome($theMsg);
					}

					echo "</div>";
/* End Update*/
/* Start Delete */
				} elseif ($do == 'Delete') { // Delete Members Page

					echo "<h1 class='text-center'>Delete Member</h1>";
					echo "<div class='container'>";

						// Check If Get Request userid Is Numeric & Get Value Of It
						$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; // Security
						//$userid = isset($_POST['userid']) && is_numeric($_POST['userid']) ? intval($_POST['userid']) : 0; // Security

						$check = checkItem('userid', 'users', $userid);

						if ($check > 0) {

							$stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
							$stmt->bindParam(":zuser", $userid);
							$stmt->execute();

							$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Deleted </div>';
							redirectHome($theMsg, 'back');

						} else {

							$theMsg = "<div class='alert alert-danger'>This ID Is Not Exist</div>";
							redirectHome($theMsg);
						}
					echo "</div>";
/* End Delete */
/* Start Activate */
				} elseif ($do == 'Activate') {

					echo "<h1 class='text-center'>Activate Member</h1>";
					echo "<div class='container'>";

						// Check If Get Request userid Is Numeric & Get Value Of It
						$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; // Security
						//$userid = isset($_POST['userid']) && is_numeric($_POST['userid']) ? intval($_POST['userid']) : 0; // Security

						$check = checkItem('userid', 'users', $userid);

						if ($check > 0) {

							$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
							$stmt->execute(array($userid));

							$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Updated </div>';
							redirectHome($theMsg, 'back');

						} else {

							$theMsg = "<div class='alert alert-danger'>This ID Is Not Exist</div>";
							redirectHome($theMsg);
						}
					echo "</div>";
				}
/*End Activate */
			include $tpl . "footer.php";
		} else {
			header('Location: index.php');
			exit();
	}

	ob_end_flush();
?>