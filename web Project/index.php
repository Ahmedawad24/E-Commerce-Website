

<?php 

  session_start();
	$pageTitle = 'login';
	include 'init.php';

	//Check if user coming from POST method

	if( $_SERVER['REQUEST_METHOD']=='POST')
	{
    if (isset($_POST['login'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$hashedPass = sha1($password);

			$stmt= $db-> prepare("SELECT 
				                      name,Password 
				                  FROM 
				                      users 
				                  Where 
				                      name=? 
				                  AND 
				                      Password=?");

			$stmt-> execute(array($username,$hashedPass));
			
			$ct= $stmt->rowCount();

			// if count > 0 this mean the database contain record about this user name.
			if($ct>0)
			{

				$_SESSION['user'] = $username;
				header("Location: index.php");
			    exit();

			}
			else
			{
				echo "<div class='container'>";
				echo '<div class="alert alert-danger text-center"> This user name not found in our database</div>';
				echo "</div>";
      }
    }
    else if(isset($_POST['signup'])){
      $user=$_POST['username'];
			$pass= $_POST['Password'];
			$hashPass = sha1($pass);
			$mail = $_POST['email'];
			$formErr=array();

    			// validate the form

    			//username valaidate
    			if(strlen($user)<4)
    			{
    				$formErr[]='username cant be less than <strong>3 char</strong>';
    			}
    			if(strlen($user)>20)
    			{
    				$formErr[]='username cant be larger than <strong>20 char</strong>';
    			}
    			if(empty($user))
    			{
    				$formErr[]='user name can\'t be <strong>empty</strong>';
    			}
    			if(checkItem('name','users',$user)==1)
    			{
    					$formErr[]= ' sorry this user is <strong>Exist</strong>';

    			}
    			//username valaidate

    			if(empty($mail))
    			{
    				
    				$formErr[]='E-mail can\'t be <strong>empty</strong>';
    			}


    			if(strlen($pass)<7)
    			{
    				$formErr[]='Password can\'t be less than <strong>6</strong>';

    			}

    			if(empty($pass))
    			{
    				$formErr[]='Password can\'t be <strong>empty</strong>';

    			}
    			
    			//Insert to database with this info
    			if(empty($formErr))
    			{
    				$stmt =$db->prepare("INSERT INTO 
    					                       users(name,password,email,regDate)
    					                       VALUES(:zuser, :zhashPass, :zemail ,now())");
		    		$stmt->execute(array(

		    			'zuser' => $user,
		    			'zhashPass'=> $hashPass,
		    			'zemail'=> $mail
		    			
		    			
		    		));
		    		echo "<div class='alert alert-success text-center'>". $stmt->rowCount(). " " . 'Added'."</div>";

    			}
    			else
    			{
    				foreach ($formErr as $Error) {

    					echo '<div class="err">' . $Error .'</div>';
    					
    				}
    				
    			}
    }
    elseif(isset($_POST['add_to_cart']))
    {
      if(isset($_SESSION["shopping_cart"]))
      {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if(!in_array($_GET["id"], $item_array_id))
        {
          $count = count($_SESSION["shopping_cart"]);
          $item_array = array(
            'item_id'			=>	$_GET["id"],
            'item_name'			=>	$_POST["hidden_name"],
            'item_price'		=>	$_POST["hidden_price"]
           
          );
          $_SESSION["shopping_cart"][$count] = $item_array;
        }
        else
        {
          header("Location: cart.php");
			    exit();
        }
      }
      else
      {
        $item_array = array(
          'item_id'			=>	$_GET["id"],
          'item_name'			=>	$_POST["hidden_name"],
          'item_price'		=>	$_POST["hidden_price"]
        );
        $_SESSION["shopping_cart"][0] = $item_array;
      }
    }

  }
  if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="index.php"</script>';
			}
		}
	}
}
?>
 
 <div class="back" style="background-image: url('image/guitar3.jpg')">
      <div class="slider">
        <div class="heading">
          <p class="p1">PENTATONIC</p>
          <h1 class="h1">The new era of MUSIC</h1>
          <div class="headingbut">
           <button onclick="window.location.href='//localhost/project-14/shop.php'">SHOP NOW</button>
          </div>
        </div>
      </div>
    </div>

    <div class="mid">
      <div class="right">
      <?php
        $stmt = $db->prepare("SELECT * FROM categories");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        foreach($rows as $row)
        {
        ?>
        <div class="txt">
          <i class="fas fa-arrow-circle-right"></i> 
          <a class="laptop"><?php echo $row['Name']?></a>
        </div>
        <?php } ?>
      </div>

      <div class="left">
      <br>
      <br>
      <br>
        <div class="photo"><img src="image/guitar2.jfif" alt="classic guitar" /></div>
        <div class="nameinfo">
          <div class="nameitem"><p> a </p></div>
          <div class="info">
            <p>
                 Acoustic strings guitar
            </p>
          </div>
          <div class="price">
            <p><b>$49.99</b></p>
          </div>
        </div>
        <div class="hidden"><button>ADD to cart</button></div>
      </div>
    </div>

    <div class="clear"></div>
    <div class="slide2">
      <p>Any sufficiently quality</p>
      <p>GUITAR<span> is indstinguishable </span></p>
      <p><span>from magic</span></p>
    </div>
    <div class="cat">
      <p>sale product</p>
      <p>Featured product</p>
      <p>Product of the day</p>
    </div>
    <div class="clear"></div>
    <div class="product">
      <div class="container">
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
        <div class="bt"><button>view shop</button></div>
      </div>
    </div>
    <div class="why"><h1>Why you should choose us?</h1></div>
    <div class="fetuers">
      <div class="item">
        <i class="fas fa-shopping-basket"></i>
        <h2>Free shipping</h2>
        <p>
          We free ship worldwide for all order above 150$. save even more with
          free shipping on many orders
        </p>
      </div>
      <div class="item">
        <i class="fas fa-hand-holding-usd"></i>
        <h2>Easy Payment</h2>
        <p>
          You can pay by Visa, Master Card or Paypal anytime anywere.Choose the
          best method.
        </p>
      </div>
      <div class="item">
        <i class="fas fa-gift"></i>
        <h2>Gift card</h2>
        <p>
          If you're in EGY,you will recive your order in 24 hours after you
          confirm purchasing.
        </p>
      </div>
      <div class="item">
        <i class="fas fa-shield-alt"></i>
        <h2>100% Guarantee</h2>
        <p>
          We guarantee 100% about our quality of products.The detail of each
          item is specific defined
        </p>
      </div>
    </div>
    <div class="videom">
      <iframe
        width="100%"
        height="425"
        src="https://www.youtube.com/embed/olTJf8OyD7A"
        frameborder="0"
        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
      ></iframe>
    </div>
    <div class="clear"></div>
    <div class="photom">
      <img src="image/guitarL.jpg" />
      <div class="text">
        <p class="pm">Acoustic</p>
        <p class="pwm">New Guitar</p>
        <p class="pom">Buy online pick up available items in an hour</p>
      </div>
    </div>
    <div class="photom2">
      <img src="image/guitarM.jpg" />
      <div class="text">
        <p class="pm">Electric</p>
        <p class="pwm"> Best Quality </p>
        <p class="pom">Let your surrounding enjoy the tune of the strings</p>
      </div>
    </div>
    <div class="photom3">
      <img src="image/guitarR.jpg" />
      <div class="text">
        <p class="pm">Exotic</p>
        <p class="pwm">signed Guitar.</p>
        <p class="pom"> Yamaha Wooden Signature </p>
      </div>
    </div>
    <div class="clear"></div>
    
   <?php
   include $tpl.'footer.php' 
   ?>
