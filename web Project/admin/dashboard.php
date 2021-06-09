
<?php

	ob_start();
	session_start();

	if(isset($_SESSION['username']))
	{
		$pageTitle = 'dashboard';
         include 'init.php';
         //$leastCour=getLatest('*','items','itemID',3);

         /* Start Dashboard Page */
?>
<div class="container home-stats text-center">
         	<h1>Dashboard</h1>
         	<div class="row">
         		<div class="col-md-3">
                 
                  <div class="stat members ">
                     <i class="fa fa-users"></i>
                     <div class="info">
                        Total Members
                        <span><a href="members.php"><?php echo calcItems('id','users'); ?></a></span>
                     </div>
                  </div>
         		</div>
         		<div class="col-md-3">
         			<div class="stat pending ">
                    <i class="fa fa-user-plus"></i>
                     <div class="info">
                        pending Members
                     <span><a href="members.php?pending=0">0</a></span>
                     </div>
         			</div>
         		</div>
         		<div class="col-md-3">
         			<div class="stat courses ">
                     <i class="fa fa-tag"></i>
                     <div class="info">
                        Total proudcts
                        <span><a href="items.php"><?php echo calcItems('itemID','items');?></a></span>
                     </div>
         			</div>
         		</div>
         		<div class="col-md-3">
         			<div class="stat comments">
                     <i class="fa fa-comments"></i>
                     <div class="info">
                        Total Comments
                       <span><a href="comments.php"> 0</a></span>
                     </div>
         			</div>
         		</div>
         	</div>
         </div>
<?php
         /* End Dashboard Page */
         


         include $tpl . 'footer.php';
			
	}
	else
	{
		header("Location: index.php");
		exit();
	}

	ob_end_flush();

?>