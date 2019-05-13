<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Register Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="../css/stylesheet.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="../images/layout/favicon.ico" type="image/x-icon">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto|Lato|ZCOOL+XiaoWei" rel="stylesheet">
    </head>
    <body>
        <?php
        require_once 'header.php';
        ?>
        <div class="register" style="margin-bottom: 150px;">
            <div id="login-row" class="text-center">
                <div id="login-column" class="col-md-12 col-md-offset-1">
                    <div id="login-box" class="col-md-9 col-md-offset-1">
                        <form class="form-inline" method="post">
                            <div class="container col-md-9 col-md-offset-1">
                                <h1 class="text-center">Sign Up</h1>
                                <p>Please fill in this form to create an account.</p>
                                <hr>
                                <label for="firstname" ><b>First Name</b></label>
                                <input type="text" placeholder="First name" name="firstname" autofocus="true" required><br>

                                <label for="lastname"><b>Last Name</b></label>
                                <input type="text" placeholder="Last name" name="lastname" required><br>

                                <label for="email"><b>  Email  </b></label>
                                <input type="text" placeholder="Email" name="email" required><br>

                                <label for="password"><b>Password</b></label>
                                <input type="password" placeholder="Password" name="password" required><br>
                                <br>
                                <p>By creating an account you agree to our Terms & Privacy.</p>

                                <div class="clearfix">
                                    <a href="index.php"><button type="button">Cancel</button></a>
                                    <input type="submit" name='register' value="Register" class='submit'/><br />
                                </div>
                                <h2>
                                    <?php
                                    $dsn = 'mysql:host=localhost;dbname=library2';
                                    $user = 'root';
                                    $pass = '';

                                    try {
                                        $pdo = new PDO($dsn, $user, $pass);
                                    } catch (PDOException $e) {
                                        die($e->getMessage());
                                    }

                                    if (isset($_POST['register'])) {
                                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $errMsg = '';
                                        $firstname = filter_input(INPUT_POST, 'firstname');
                                        $lastname = filter_input(INPUT_POST, 'lastname');
                                        $email = filter_input(INPUT_POST, "email");
                                        $password = filter_input(INPUT_POST, 'password');
                                        $hash = password_hash($password, PASSWORD_DEFAULT);

                                        if ($firstname == '') {
                                            $errMsg = 'Enter your first name';
                                        } else if ($lastname == '') {
                                            $errMsg = 'Enter your last name';
                                        } else if ($email == '') {
                                                $errMsg = 'Enter your email';
                                        } else if ($password == '') {
                                                $errMsg = 'Enter password';
                                        }        
                                        
                                        if ($errMsg == '') {
                                                try {
                                                    $stmt = $pdo->prepare('INSERT INTO member (first_name, last_name, email, password) VALUES (:firstname, :lastname, :email, :password)');
                                                    $stmt->execute(array(
                                                        ':firstname' => $firstname,
                                                        ':lastname' => $lastname,
                                                        ':email' => $email,
                                                        ':password' => $hash,
                                                    ));
                                                    header("Location: http://localhost/LibraryApp/public_html/html/logInPage.php");
                                                } catch (PDOException $e) {
                                                    echo $e->getMessage();
                                                    //error - account for this email address already exists
                                                }
                                            }
                                        }
                                        ?>
                                    </h2>
                                    <br><br>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

    <?php
    //Footer 
    require_once 'footer.php';
    ?> 
    </body>
</html>
