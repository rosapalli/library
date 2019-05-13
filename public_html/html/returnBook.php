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
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    </head>
    <body>       
        <?php
        session_start();
        if (isset($_SESSION["email"])) {
            require_once 'headerlogin.php';
        } else {
            require_once 'header.php';
        } $dsn = 'mysql:host=localhost;dbname=library2';
        $user = 'root';
        $pass = '';
        try {
            $pdo = new PDO($dsn, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        ?>
        <div id="container2" class="container">
            <div class="row">
                <?php
                try {
                    $bookID = $_GET['bookID'];
//                    $query = "SELECT member_ID FROM member WHERE email = '$_SESSION[email]'";
//                    $statement = $pdo->prepare($query);
//                    $statement->execute();
//                    $memberID = $statement->fetch();
//                    $memberID = $memberID['member_ID'];

                    $returnBook = $pdo->prepare("CALL returnBook(?,?)");
                    $returnBook->bindParam(1, $bookID);
                    $returnBook->bindParam(2, $memberID);

                    $returnBook->execute();

//                        $selectBook = "SELECT book_id, title
//                            FROM book WHERE
//                            book_id = $bookID";
//                        $updateLoan = "UPDATE loanbook
//                            SET loan_status= 0
//                            WHERE loanbook.book_id = $bookID";
//                        $updateLoan2 = "UPDATE loanbook 
//                            SET loan_end = NOW()
//                            WHERE loanbook.book_id = $bookID";
//                        $updateBook = "UPDATE book
//                            SET status= 'on shelf'
//                            WHERE book_id = $bookID";
//                        
//                        $bookDetails = $pdo->prepare($selectBook);
//                        $loanStatus = $pdo->prepare($updateLoan);
//                        $loanEnd = $pdo->prepare($updateLoan2);
//                        $bookStatus = $pdo->prepare($updateBook);
//                        $bookDetails->execute();
//                        $loanStatus->execute();
//                        $loanEnd->execute();
//                        $bookStatus->execute();
                    echo "<br>" . "<h2>Book returned successfully <br>";
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
                ?>
                <br><br>
                <a class="btn btn-primary btn-default" href="index.php" role="button">Search for more books &raquo;</a>
            </div>
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>