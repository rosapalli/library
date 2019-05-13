<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header" >
      <img src="../images/layout/logolight.png" height="50px" width="40px">
      <a class="navbar-brand" font-family: 'ZCOOL XiaoWei', serif; href="index.php">WHAKATANE LIBRARY</a>
    </div>
      <form class="navbar-form navbar-left" action="search.php" method="POST">
      <div class="form-group">
          <input type="text" class="form-control" placeholder="Title or Author" name='search_book' required>
      </div>
      <button type="submit" name="nsubmit" class="btn btn-default">SEARCH</button>
    </form>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php">HOME</a></li>
      <li><a href="LogInPage.php">LOGIN</a></li>
      <li><a href="#">CONTACT</a></li>
    </ul>
    
  </div>
</nav>