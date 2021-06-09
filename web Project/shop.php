<!DOCTYPE >
<?php 

  session_start();
	$pageTitle = 'login';
	include 'init.php';
?>

<p class="Mshop"> My shop</p>
      <div class="product">
      <?php
        $stmt = $db->prepare("SELECT * FROM items ORDER BY itemID DESC  LIMIT 8");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        foreach ($rows as $row)
        {
        ?>
        <div class="box">
          <form method="post" action="index.php?action=add&id=<?php echo $row["itemID"];?>">
            <img src="image/guitar left.jpg" />
            <p><?php echo $row['Name']?></p>
            <p class="price"><?php echo $row['price']?></p>
            <div class="hidden2">
            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
            </div>
            <input type="hidden" name="hidden_name" value="<?php echo $row["Name"]; ?>" />

						<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
        </form>
        </div>
        <?php } ?>
      </div>
        <div class="clear"></div>
        <?php
   include $tpl.'footer.php' 
   ?>