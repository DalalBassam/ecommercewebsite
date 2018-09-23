<?php 
	session_start();
	include 'init.php';


?>


    <!-- Start Carousel -->

    <div id="myslide" class="carousel slide hidden-xs" data-ride="carousel">

        <ol class="carousel-indicators">
            <li data-target="#myslide" data-slide-to="0" class="active"></li>
            <li data-target="#myslide" data-slide-to="1"></li>
            <li data-target="#myslide" data-slide-to="2"></li>
            <li data-target="#myslide" data-slide-to="3"></li>
        </ol>

        <div class="carousel-inner">

            <div class="item active">
                <img src="images/03.jpg" width="1920" height="600" alt="Pic 1">
                <div class="carousel-caption hidden-xs">
            <p class="lead">
                        Welcome to the website of e-commerce
                        You can sell your product in our website</p>
                    <button class="button btn-lg">  <a href="newad.php"> Advertise here </a></button>

                </div>
            </div>

            <div class="item">
                <img src="images/02.jpg" width="1920" height="600" alt="Pic 2">

            </div>

            <div class="item">
                <img src="images/01.jpg" width="1920" height="600" alt="Pic 3">

            </div>

            <div class="item">
                <img src="images/04.jpg" width="1920" height="600" alt="Pic 4">

            </div>

        </div>

        <a class="left carousel-control" href="#myslide" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>

        <a class="right carousel-control" href="#myslide" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>

    </div>

    <!-- End Carousel -->




    <div class="container">

    <div  class="my-ads block">
    <div class="row">



		<?php
 
		if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
			$category = intval($_GET['pageid']);
            echo '<h3 class="text-center">Show Category Items</h3>';
            include'admin/connect.php';

              $stmt = $con->query("SELECT * FROM items where Cat_ID =' $category'");
			while ($item = $stmt->fetch()) {
                		echo '<div class="col-md-4 col-sm-6">';
                
                	echo '<div class="thumbnail item-box">';
		
                		echo '<span class="price-tag">$' . $item['Price'] . '</span>';
								echo '<img class="img-responsive img_item" src="uploades/'. $item['image'] .' " alt="" />';
				           
               
                
                        echo'<div class="caption">';
									echo '<h3  class="text-center"><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a>
                                    </h3>';
									echo '<p>' . $item['Description'] . '</p>';
                        echo '</div>';
                        

                 echo'<div class="footer-box">';
                         echo'  <button class="button" ><a href="items.php?itemid='. $item['Item_ID'] .'"> Details </a></button>';

                       		echo '<div class="date">' . $item['Add_Date'] . '</div>';
                  echo'</div>';
                        
                        
                 
					echo '</div>';
						echo '</div>';


			}
		} else {
			echo 'You Must Add Page ID';
		}
		?>
	</div>
        </div>
</div>



<?php include $tpl . 'footer.php'; ?>