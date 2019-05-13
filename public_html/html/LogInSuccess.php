<!DOCTYPE html>
<html>
    <head>
        <title>Log In Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link href="../css/stylesheet.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        require_once 'headerlogin.php';
        //login_success.php  
        session_start();
        ?>
        <div class="container">
            <div class="col-md-9 col-md-offset-1">  
                <?php
                $host = "localhost";
                $username = "root";
                $password = "";
                $database = "library2";
                $message = "";
                $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               try{ if(isset($_SESSION["email"])){
                $query = "SELECT first_name FROM member WHERE email = '$_SESSION[email]'";
                $statement = $connect->prepare($query);
                $statement->execute();
                $firstName = $statement->fetch();
                echo "<h3>Login Success, Welcome $firstName[first_name]</h3>";
                $logout = '<br /><br /><a href="logout.php">Logout</a>';
                } else{
                header("location:LogInPage.php");
               } } catch(PDOException $error) {
            $message = $error->getMessage();
        }
                ?>
                <br>
                <a class="btn btn-info btn-lg" style="color: black;" href="index.php" role="button">Homepage &raquo;</a>
                <?php echo $logout; ?>
                <br>
                <br>
            </div>
        </div>

        <?php
        require_once 'footer.php';
        ?> 
    </body>
</html>