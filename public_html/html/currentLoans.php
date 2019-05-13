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
        //login_success.php  
        session_start();
        if (isset($_SESSION["email"])) {
            require_once 'headerlogin.php';
        } else {
            require_once 'header.php';
        }
        ?>
        <div class="container">
            <div class="col-md-9 col-md-offset-1">  
                <?php
                $host = "localhost";
                $username = "root";
                $password = "";
                $database = "library2";
                $message = "";
                $pdo = new PDO("mysql:host=$host; dbname=$database", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               try { if (isset($_SESSION["email"])) {
                    $query = "SELECT member_ID FROM member WHERE email = '$_SESSION[email]'";
                    $statement = $pdo->prepare($query);
                    $statement->execute();
                    $memberID = $statement->fetch();
                    $memberID = $memberID['member_ID'];

                    $loans = "SELECT loan_start, loan_end, title, first_name, last_name, book.book_id "
                            . "FROM loanbook "
                            . "INNER JOIN book "
                            . "ON loanbook.book_id = book.book_id "
                            . "INNER JOIN book_author "
                            . "ON book.book_id = book_author.book_id "
                            . "INNER JOIN author "
                            . "ON book_author.author_ID = author.author_ID "
                            . "WHERE member_ID = '$memberID' AND loanbook.loan_status = 1";

                    $checkLoans = $pdo->prepare($loans);
                    $checkLoans->execute();
                    $row_cnt = $checkLoans->rowCount();
                    if ($row_cnt == 0) {
                        echo "You have no active loans.";
                    } else {
                        $currentLoans = $checkLoans->fetchAll();
                        foreach ($currentLoans as $currentLoan) {
                            echo "Title: $currentLoan[title], "
                            . "Author: $currentLoan[first_name] $currentLoan[last_name], "
                            . "Loan start: $currentLoan[loan_start], "
                            . "Loan due: $currentLoan[loan_end] <br>";
                            $bookID = $currentLoan['book_id'];
                            echo "<form action='returnBook.php'><input type='hidden' name='bookID' value='$bookID'><button type='submit' method = 'GET'>Return book</button></form>";
                        }
                    }
                }
               } catch (PDOException $error) {
            $message = $error->getMessage();
        }
                ?>
                <br>
                <br>
                <br>
            </div>
        </div>

        <?php
        require_once 'footer.php';
        ?> 
    </body>
</html>