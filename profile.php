<?php
	ob_start();
	session_start();
	$pageTitle = 'Profile';
	include 'init.php';
	if (isset($_SESSION['user'])) {
        $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
        $getUser->execute(array($sessionUser));
        $info = $getUser->fetch();
        $userid = $info['UserID'];
        ?>


        <h1 class="text-center">My Profile</h1>
        <div class="information block">
            <div class="container">
                <div class="panel ">
                    <div class="panel-heading panel-green">My Information</div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <li>
                                <i class="fa fa-unlock-alt fa-fw"></i>
                                <span>Login Name</span> : <?php echo $info['Username'] ?>
                            </li>
                            <li>
                                <i class="fa fa-envelope-o fa-fw"></i>
                                <span>Email</span> : <?php echo $info['Email'] ?>
                            </li>
                            <li>
                                <i class="fa fa-user fa-fw"></i>
                                <span>Full Name</span> : <?php echo $info['FullName'] ?>
                            </li>
                            <li>
                                <i class="fa fa-calendar fa-fw"></i>
                                <span>Registered Date</span> : <?php echo $info['Date'] ?>
                            </li>
                            <li>
                                <i class="fa fa-tags fa-fw"></i>
                                <span>Fav Category</span> :
                            </li>
                        </ul>
                        <a href="#" class="btn btn-default">Edit Information</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="my-ads" class="my-ads block">
        <div class="container">


                    <h1>My Items</h1>
        <div class="row">

                        <?php
                        include 'admin/connect.php';
                        $stmt = $con->query("SELECT * FROM items where Member_ID = $userid");
                        while ($item = $stmt->fetch()) {


                            echo '<div class="col-md-4 col-sm-6">';

                            echo '<div class="thumbnail item-box">';
                            if ($item['Approve'] == 0) {
                                echo '<span class="approve-status">Waiting Approval</span>';
                            }

                            echo '<span class="price-tag">$' . $item['Price'] . '</span>';
                            echo '<img class="img-responsive" src="uploades/' . $item['image'] . ' " alt="" />';


                            echo '<div class="caption">';
                            echo '<h3  class="text-center"><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a>
                                    </h3>';
                            echo '<p>' . $item['Description'] . '</p>';
                            echo '</div>';

                            echo '<div class="footer-box">';
                            echo '<button class="button" ><a href="items.php?itemid=' . $item['Item_ID'] . '">Details  </a></button>';
                            echo '<div class="date">' . $item['Add_Date'] . '</div>';
                            echo '</div>';

                            echo '</div>';
                            echo '</div>';


                        }


                        ?>


        <?php
    }else {
					echo 'Sorry There\' No Ads To Show, Create <a href="newad.php">New Ad</a>';
				}
			?>

    </div>
    </div>
   </div>


<?php
	include $tpl . 'footer.php';
	ob_end_flush();
?>