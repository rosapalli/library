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
        session_start();
        require_once 'header.php';
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "library2";
        $message = "";
        try {
            $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (isset($_POST["login"])) {
                if (empty($_POST["email"]) || empty($_POST["password"])) {
                    $message = '<label>All fields are required</label>';
                } else {
                    $query = "SELECT * FROM member WHERE email = :email AND password = :password";
                    $statement = $connect->prepare($query);
                    $statement->execute(
                            array(
                                'email' => filter_input(INPUT_POST, "email"),
                                'password' => filter_input(INPUT_POST, "password")
                            )
                    );
                    $count = $statement->rowCount();
                    if ($count > 0) {
                        $_SESSION["email"] = filter_input(INPUT_POST, 'email');
                        header("location:LogInSuccess.php");
                    } else {
                        $message = '<label>Wrong email/password combination </label>';
                    }
                }
            }
        } catch (PDOException $error) {
            $message = $error->getMessage();
        }
        ?>
        <div class="login" style="margin-top: 80px;">
            <h2 class="text-center">Log In To Whakatane Public Library</h2>

            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6 col-md-offset-3">
                    <div id="login-box" class="col-md-6 col-md-offset-3">
                        <form method="post">  
                            <label>Email</label>  
                            <input type="text" name="email" class="form-control" />  
                            <br />  
                            <label>Password</label>  
                            <input type="password" name="password" class="form-control" />  
                            <br /> 
                            <div class="clearfix">
                                <input type="submit" name="login" class="btn btn-info" value="Login" /> 
                                <input type="submit" formaction="register.php" value="Register" class="btn btn-info"/> 
                            </div>
                            <h2> 
<?php
if (isset($message)) {
    echo '<label class="text-danger">' . $message . '</label>';
}
?>
                            </h2>               
                        </form>  
                    </div>
                </div>
            </div>
        </div>
                                <?php
                                require_once 'footer.php';
                                ?> 
    </body>
</html>
