

 <!--Start our navBar-->
          <div class="topnav">
      <div class="container">
        <div class="parent">
          <i class="fas fa-bars menu"></i>
          <a href="#" class="Eshop"> <span>E</span>-Shop </a>
          <i class="fas fa-search center"></i>
          <input type="search" class="search" placeholder="Enter...." />
          <i class="far fa-user user click"></i>
          <i class="fas fa-shopping-bag user "></i>
          <ul class="sub-menu">
            <li><a href="#"><?php echo $_SESSION['username'] ?></a></li>
            <li><a href="#">setting</a></li>
            <li><a href="../index.html">main page</a></li>
            <li><a href="logout.php">logout</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="menu-bar">
      <ul>
        <li><a href="members.php">Members</a></li>
        <li><a href="cata.php">categories</a></li>
        <li><a href="items.php">items</a></li>
        <li><a href="comments.php">comments</a></li>
      </ul>
    </div>
                

