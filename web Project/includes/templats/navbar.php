

 <!--Start our navBar-->
 <div class="topnav">
      <div class="container">
        <div class="parent">
          <i class="fas fa-bars menu"></i>
          <a href="index.php" class="Eshop"> <span>P</span>entaTonic </a>
          <i class="fas fa-search center"></i>
          <input type="search" class="search" placeholder="Enter...." />
          <i class="far fa-user user click"></i>
          <a href="cart.php"><i class="fas fa-shopping-bag user "></i></a>
          <ul class="sub-menu">
            <?php if(isset($_SESSION['user'])){?>
            <li><a href="http://localhost/project-14/profile.php"><?php echo $_SESSION['user']?></a></li>
            <li><a href="logout.php">logout<a></li>
            <?php }
            else{
            ?>
             <li id="login">login</li>
             <li id="signup">signup</li>
            <?php }?>
          </ul>
        </div>
      </div>
    </div>
    <div class="menu-bar">
      <ul>
        <img src="image/guitar left.jpg" />
        <img src="image/Shop.jpg" />
        <img src="image/admin4.jpg" /><br>
        <li><a href="http://localhost/project-14/index.php">Home</a></li>
        <li><a href="http://localhost/project-14/shop.php">Shop</a></li>
        <li><a href="http://localhost/project-14/admin/">admin</a></li>
      </ul>
    </div>
     <!-- login form !-->
     <div class="log">
      <div class="login">
        <form method="POST" action="index.php">
          <div class="ok2">
            <input placeholder="Username" name="username" />
            <input placeholder="password" required type="password" name="password"/>
            <input name="login" type="submit" value="login"/>
          </div>
        </form>
      </div>
    </div>

          <div class="sign">
                <div class="signup">
                        <form method="POST" action="index.php">
                            <div class="not1">
                                
                            </div>
                            <div class="ok1">
                            <input placeholder="User Name" name="username" type="text">
                            <input placeholder="Password" name="Password" type="password">
                            <input placeholder="E-mail" type="email" name="email">
                            <input name="signup" type="submit" value="Signup">
                            </div>
                        </form>
                </div>
        </div>

