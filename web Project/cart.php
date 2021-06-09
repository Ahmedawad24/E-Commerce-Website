<?php 

  session_start();
    include 'init.php';
?>

					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					
						
						<div class="box car">
							<img src="image/guitar left.jpg" />
							<p><?php echo $values["item_name"];?></p>
							<p class="price"><?php echo $values["item_price"];?></p>
							<div class="hidden2">
								<a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a>	
							</div>
							
						</div>
					
					<?php
							
						}
					?>
					
					<?php
					}
					?>
						<div class="clear"></div>
						<?php
   include $tpl.'footer.php' 
   ?>