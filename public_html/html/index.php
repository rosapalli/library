<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Whakatane Library</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="../css/stylesheet.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="../images/layout/favicon-16x16.png" type="image/x-icon">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto|Lato|ZCOOL+XiaoWei" rel="stylesheet">
    </head>
    <body>
 <?php 
 session_start();
         if(isset($_SESSION["username"]))  {
            include_once("headerlogin.php");
        }else{
            include_once("header.php");
        }
 ?>

      <div class="jumbotron">
        <div class="container justify-content-center">
          <h1 style="color: #871570;" class="display-3">Welcome to the Library!</h1>
          <form class="form-inline search-query input-mysize" method="post" action="search.php" role="search">
    <div class="input-group search-query add-on" style="width:80%">
      <input class="form-control input-large" placeholder="Enter your search term here" name="srch-term" id="srch-term" type="text">
      </div>
              <br>
      <div class="input-group radio-inline">
          <label><input type="radio" name="opt[]" value="title" required><span style="color:#871570">Search by Title</span></label>
      </div>
      <div class="input-group radio-inline">
          <label><input type="radio" name="opt[]" value="author"><span style="color:#871570">Search by Author</span></label>
      </div>
       <div class="input-group-btn">
        <button class="btn btn-default" name="submit" type="submit">SEARCH</button>
      </div>
  </form>
          <br>
          <a class="btn btn-info btn-lg" style="color: black;" href="#" role="button">View the full catalogue &raquo;</a></p>
        </div>
      </div>

      <div id="container2" class="container">
        <div class="row">
          <div id="library" class="col-md-8">
            <h2>NEW LIBRARY ADDITIONS</h2>
            <p> The library has a wide selection of both books and DVD's in its catalogue which are updated weekly. </p>
            <p>
                <a class="btn btn-secondary" href="#" role="button">View full library &raquo;</a></p>
            <div class="col-md-8">
                <img src="../images/content/book1.jpg" height="200px" width="120px">
                <img src="../images/content/book2.jpg" height="200px" width="120px">
                <a href="itemdetail.php"><img src="../images/content/book3.jpg" height="200px" width="120px"></a>
            </div>
          </div>
          <div class="col-md-4">
            <h2>OPENING HOURS</h2>
            <p>Monday: 9am - 5pm<br>
            Tuesday: 9am - 5pm<br>
            Wednesday: 9am - 5pm<br>
            Thursday: 9am - 5pm<br>
            Friday: 9am - 5pm<br>
            Saturday: 9am - 5pm<br>
            Sunday: Closed</p>
            <p>
            <a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
          </div>
        </div>
      </div>
        
     <?php 
 require_once 'footer.php';
 ?> 
        
    </body>
</html>
