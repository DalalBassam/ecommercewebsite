<?php
	ob_start();
	/*

	 Items Page

	*/

	session_start();

	$pageTitle = 'Items';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
/*-Start-Manage-*/
		if ($do == 'Manage') {

			// Join items
			$stmt = $con->prepare("SELECT 
										items.*,
										categories.Name AS Category_Name,
										users.Username
									From
										items
									INNER JOIN
										categories
									ON
										categories.ID = items.Cat_ID
									INNER JOIN
										users
									ON
										users.UserID = items.Member_ID
									ORDER BY 
										Item_ID DESC");
			try {
				$stmt->execute(); // Execute The Statment
				$items = $stmt->fetchAll(); // Asign To Variable
			} catch(PDOException $e) {
				die($e->getMessage());
			}

			if (!empty($items)) {
?>
			<h1 class="text-center">Manage Items</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding Date</td>
							<td>Category</td>
							<td>Username</td>
							<td>Control</td>
						</tr>
<?php
							foreach ($items as $item) {
								echo '<tr>';
									echo '<td>' . $item['Item_ID'] . '</td>';
									echo '<td>' . $item['Name'] . '</td>';
									echo '<td>' . $item['Description'] . '</td>';
									echo '<td>' . $item['Price'] . '</td>';
									echo '<td>' . $item['Add_Date'] . '</td>';
									echo '<td>' . $item['Category_Name'] . '</td>';
									echo '<td>' . $item['Username'] . '</td>';
									echo '<td>
										<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
										<a href="items.php?do=Delete&itemid=' . $item['Item_ID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a> ';
										if ($item['Approve'] == 0) {
											echo '<a href="items.php?do=Approve&itemid=' . $item['Item_ID'] . '" class="btn btn-info"><i class="fa fa-check"></i> Approve</a>';
										}
									echo '</td>';
								echo '</tr>';
							}
?>
					</table>
				</div>
				<a href="items.php?do=Add" class="btn btn-sm ">
					<i class="fa fa-plus"></i> New Item</a>
			</div>
<?php 				} else {
						echo '<div class="container">';
							echo '<div class="nice-message">';
								echo 'There\'s No Recorde To Show';
							echo '</div>';
							echo '<a href="items.php?do=Add" class="btn btn-sm ">
									<i class="fa fa-plus"></i> New Items</a>';
						echo '</div>';
					} 
?>
<?php

/*-Start-Add-*/
		} elseif ($do == 'Add') {



?>		<h1 class="text-center">Add New Item</h1>
<div class="container Add_items">
    <div class="panel">
        <div class="panel-heading">
            <i class="fa fa-edit"></i> Add New Item</div>


        <div class="panel-body">
				<form class="form-horizontal" action="?do=Insert" method="POST">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" placeholder="Name Of The Item" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control" placeholder="Name Of The Description" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="price" class="form-control" placeholder="Price Of The Item" />
						</div>
					</div>
					<!-- End Price Field -->
					<!-- Start Country Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country Made</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="country" class="form-control" placeholder="Country Of Made" />
						</div>
					</div>
					<!-- End Country Field -->
					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-6">
							<select name="status">
								<option value="0">...</option>
								<option value="1">New</option>
								<option value="2">Like New</option>
								<option value="3">Used</option>
								<option value="4">Very Old</option>
							</select>
						</div>
					</div>
					<!-- End Status Field -->
					<!-- Start Members Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Member</label>
						<div class="col-sm-10 col-md-6">
							<select name="member">
								<option value="0">...</option>
								<?php
									$stmt = $con->prepare("SELECT * FROM users ");
									$stmt->execute();
									$users = $stmt->fetchAll();

									foreach ($users as $user) {
										echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!-- End Members Field -->
					<!-- Start Categories Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10 col-md-6">
							<select name="category">
								<option value="0">...</option>
								<?php
									$stmt2 = $con->prepare("SELECT * FROM categories ");
									$stmt2->execute();
									$cats = $stmt2->fetchAll();

									foreach ($cats as $cat) {
										echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!-- End Categories Field -->
					<!-- Start Submit Field -->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Item" class="btn  btn-sm" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>
    </div>
</div>
<?php
/*-End-Add-*/
/*-Start-Insert-*/
		} elseif ($do == 'Insert') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insert Item</h1>";
				echo "<div class='container'>";

				// Get Variables From The Form
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				$country 	= $_POST['country'];
				$status 	= $_POST['status'];
				$member 	= $_POST['member'];
				$category 	= $_POST['category'];

				$formError = array(); // Validate Form

				if (empty($name)) {
					$formError[] = 'Name Can\'t Be <strong>Empty</strong>';
				}
				if (empty($desc)) {
					$formError[] = 'Description Can\'t Be <strong>Empty</strong>';
				}
				if (empty($price)) {
					$formError[] = 'Price Can\'t Be <strong>Empty</strong>';
				}
				if (empty($country)) {
					$formError[] = 'Country Can\'t Be <strong>Empty</strong>';
				}
				if ($status == 0) {
					$formError[] =  'You Must Choose The <strong>Status</strong>';
				}
				if ($member == 0) {
					$formError[] =  'You Must Choose The <strong>Member</strong>';
				}
				if ($category == 0) {
					$formError[] =  'You Must Choose The <strong>Category</strong>';
				}

				// Loop Into Errors Array And Echo It
				foreach ($formError as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation
				if (empty($formError)) {

					// Insert Userinfo In Database
					$stmt = $con->prepare("INSERT INTO  items(Name,
														Description, 
														Price, 
														Country_Made, 
														Status, 
														Add_Date,
														Cat_ID,
														Member_ID) 
												VALUES(	:zname,
														:zdesc,
														:zprice, 
														:zcountry, 
														:zstatus, 
														now(),
														:zcategory,
														:zmember)");
					$stmt->execute(array(':zname' 		=> $name,
										 ':zdesc'		=> $desc, 
										 ':zprice'	 	=> $price, 
										 ':zcountry' 	=> $country,
										 ':zstatus'	 	=> $status,
										 ':zcategory'	=> $category,
										 ':zmember'		=> $member));

					// Echo Success Message
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Inserted </div>';
					redirectHome($theMsg, 'back');
				}
			} else {
				echo "<div class = 'container'>";

					$theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Bage Directly</div>";
					redirectHome($theMsg, 5);

				echo "</div>";
			}

			echo "</div>";
		
/*-End-Insert-*/
/*-Start-Edit-*/
		} elseif ($do == 'Edit') {

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; // Security : Check If Get Request itemid Is Numeric & Get Value Of It

			$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?"); // Select All Data Depend On This ID

			$stmt->execute(array($itemid)); // Execute Query

			$item = $stmt->fetch(); // Fetch The Data

			$count = $stmt->rowCount(); // The Row Count → if Theres Such ID Show The Form

			if ($count > 0) {



?>			<h1 class="text-center">Edit Item</h1>
<div class="container Edit_Item">
    <div class="panel">
        <div class="panel-heading">
            <i class="fa fa-edit"></i>Edit Item </div>


        <div class="panel-body">

					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="name" value="<?php echo $item['Name'] ?>" class="form-control" placeholder="Name Of The Item" />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="description" value="<?php echo $item['Description'] ?>" class="form-control" placeholder="Name Of The Description" />
							</div>
						</div>
						<!-- End Description Field -->
						<!-- Start Price Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="price" value="<?php echo $item['Price'] ?>" class="form-control" placeholder="Price Of The Item" />
							</div>
						</div>
						<!-- End Price Field -->
						<!-- Start Country Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country Made</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="country" value="<?php echo $item['Country_Made'] ?>" class="form-control" placeholder="Country Of Made" />
							</div>
						</div>
						<!-- End Country Field -->
						<!-- Start Status Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-6">
								<select name="status">
									<option value="1" <?php if ($item['Status'] == 1) { echo "selected"; } ?> >New</option>
									<option value="2" <?php if ($item['Status'] == 2) { echo "selected"; } ?> >Like New</option>
									<option value="3" <?php if ($item['Status'] == 3) { echo "selected"; } ?> >Used</option>
									<option value="4" <?php if ($item['Status'] == 4) { echo "selected"; } ?> >Very Old</option>
								</select>
							</div>
						</div>
						<!-- End Status Field -->
						<!-- Start Members Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Member</label>
							<div class="col-sm-10 col-md-6">
								<select name="member">
									<?php
										$stmt = $con->prepare("SELECT * FROM users ");
										$stmt->execute();
										$users = $stmt->fetchAll();

										foreach ($users as $user) {

											echo "<option value='" . $user['UserID'] . "'";
											if ($item['Member_ID'] == $user['UserID']) { echo "selected"; }
											echo ">" . $user['Username'] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
						<!-- End Members Field -->
						<!-- Start Categories Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Category</label>
							<div class="col-sm-10 col-md-6">
								<select name="category">
									<?php
										$stmt2 = $con->prepare("SELECT * FROM categories ");
										$stmt2->execute();
										$cats = $stmt2->fetchAll();

										foreach ($cats as $cat) {
											echo "<option value='" . $cat['ID'] . "'";
											if ($item['Cat_ID'] == $cat['ID']) { echo "selected"; }
											echo ">" . $cat['Name'] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
						<!-- End Categories Field -->
						<!-- Start Submit Field -->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save Item" class="btn btn-primary btn-sm" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
        </div>
    </div>

<?php
					$stmt = $con->prepare("SELECT
												comments.*, users.Username As Member
											FROM 
												comments
											INNER JOIN
												users
											ON
												users.UserID = comments.user_id
											WHERE
												item_id = ?");
					try {
						$stmt->execute(array($itemid)); // Execute The Statment
						$rows = $stmt->fetchAll(); // Asign To Variable
					} catch(PDOException $e) {
						die($e->getMessage());
					}

					if (!empty($rows)) { // If Table Is Impty
					
?>
						<h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1>
						<div class="table-responsive">
							<table class="main-table text-center table table-bordered">
								<tr>
									<td>Comment</td>
									<td>User Name</td>
									<td>Added Date</td>
									<td>Control</td>
								</tr>
								<?php
									foreach ($rows as $row) {
										echo '<tr>';
											echo '<td>' . $row['comment'] . '</td>';
											echo '<td>' . $row['Member'] . '</td>';
											echo '<td>' . $row['comment_date'] . '</td>';
											echo '<td>
													<a href="comments.php?do=Edit&comid=' . $row['c_id'] . '" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
													<a href="comments.php?do=Delete&comid=' . $row['c_id'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a> ';

													if ($row['status'] == 0) {
														echo '<a href="comments.php?do=Approve&comid=' . $row['c_id'] . '" class="btn btn-info"><i class="fa fa-close"></i> Approve</a>';
													}

											echo '</td>';
										echo '</tr>';
									}
								?>
							</table>
						</div>
<?php
					}
?>

				</div>
<?php
			} else { // If Theres No Such ID Show Error Message
				echo "<div class='container'>";

					$theMsg = "<div class='alert alert-danger'>Theres No Such ID</div>";
					redirectHome($theMsg);

				echo "</div>";
			}

/*-End-Edit-*/
/*-Start-Update-*/
		} elseif ($do == 'Update') {

			echo "<h1 class='text-center'>Update Item</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check Request Method

				$id 		= $_POST['itemid']; // Get Variables From The Form
				$name 	 	= $_POST['name'];
				$desc 	 	= $_POST['description'];
				$price 	 	= $_POST['price'];
				$country	= $_POST['country'];
				$status 	= $_POST['status'];
				$member 	= $_POST['member'];
				$cat 		= $_POST['category'];

				$formError = array(); // Validate Form
				if (empty($name)) {
					$formError[] = 'Name Can\'t Be <strong>Empty</strong>';
				}
				if (empty($desc)) {
					$formError[] = 'Description Can\'t Be <strong>Empty</strong>';
				}
				if (empty($price)) {
					$formError[] = 'Price Can\'t Be <strong>Empty</strong>';
				}
				if (empty($country)) {
					$formError[] = 'Country Can\'t Be <strong>Empty</strong>';
				}
				if ($status == 0) {
					$formError[] =  'You Must Choose The <strong>Status</strong>';
				}
				if ($member == 0) {
					$formError[] =  'You Must Choose The <strong>Member</strong>';
				}
				if ($cat == 0) {
					$formError[] =  'You Must Choose The <strong>Category</strong>';
				}

				foreach ($formError as $error) { // Loop Into Errors Array And Echo It
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

					if (empty($formError)) { // Check If There's No Error Proceed The Update Operation

						$stmt = $con->prepare("UPDATE
													items
												SET
													Name 			= ?,
													Description 	= ?,
													Price 			= ?,
													Country_Made 	= ?,
													Status 			= ?,
													Cat_ID 			= ?,
													Member_ID 		= ?
												WHERE
													Item_ID 		= ?");

						$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $id));

						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Updated </div>'; // Echo Success Message
						redirectHome($theMsg, 'back', 5);
					}
			} else {

				$theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Bage Directly</div>";
				redirectHome($theMsg);
			}

			echo "</div>";

/*-End-Update-*/
/*-Start-Delete-*/
		} elseif ($do == 'Delete') {

			echo "<h1 class='text-center'>Delete Items</h1>";
			echo "<div class='container'>";

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; // Security : Check If Get Request itemid Is Numeric & Get Value Of It

				$check = checkItem('Item_ID', 'items', $itemid); // Select All Data Depend On This ID

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");
					$stmt->bindParam(":zid", $itemid);
					$stmt->execute();

					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Deleted </div>';
					redirectHome($theMsg, 'back');

				} else {

					$theMsg = "<div class='alert alert-danger'>This ID Is Not Exist</div>";
					redirectHome($theMsg);
				}
			echo "</div>";

/*-End-Delete-*/
/*-Start-Approve-*/
		} elseif ($do == 'Approve') {

			echo "<h1 class='text-center'>Approve Item</h1>";
			echo "<div class='container'>";

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; // Security: Check If Get Request userid Is Numeric & Get Value Of It

				$check = checkItem('Item_ID', 'items', $itemid);

				if ($check > 0) {

					$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
					$stmt->execute(array($itemid));

					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Approve </div>';
					redirectHome($theMsg, 'back');

				} else {

					$theMsg = "<div class='alert alert-danger'>This ID Is Not Exist</div>";
					redirectHome($theMsg);
				}
			echo "</div>";
/*-End-Approve-*/
		}

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');
		exit();
	}

	ob_end_flush();
?>
