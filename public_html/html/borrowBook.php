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
        }
        $dsn = 'mysql:host=localhost;dbname=library2';
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
                if(isset($_SESSION["email"])) {
                $bookID = $_GET['bookID'];
                
                $query = "SELECT member_ID FROM member WHERE email = '$_SESSION[email]'";
                $statement = $pdo->prepare($query);
                $statement->execute();
                $memberID = $statement->fetch();
                $memberID = $memberID['member_ID'];

                $statusCheckSQL = "SELECT * FROM book WHERE status = 'on shelf' AND book.book_ID = $bookID";
                $statusCheckSQLResult = $pdo->prepare($statusCheckSQL);
                $statusCheckSQLResult->execute();
                $number_of_rows = $statusCheckSQLResult->fetchColumn();

                if ($number_of_rows === FALSE) {
                    echo "This book is currently not available";
                } else {
                    
                    $borrowBook = $pdo->prepare("CALL borrowBook(?,?)");
                    $borrowBook->bindParam(1,$bookID);
                    $borrowBook->bindParam(2, $memberID);
                    $borrowBook->execute();
//                    $loanBookSQL = "INSERT INTO loanbook(book_id, member_id, loan_start, loan_end, loan_status)
//       VALUES($bookID, $memberID, NOW(),(DATE_ADD(NOW(), INTERVAL 21 DAY)), 1);";
//                    $updateBookSQL = "UPDATE book SET status= 'on loan' WHERE book.book_id = $bookID"; 
//
//                    $loanBookSQLResult = $pdo->prepare($loanBookSQL);
//                    $updateBookSQLResult = $pdo->prepare($updateBookSQL);
////    $getLoanEndDateResult = $connection->prepare($getLoanEndDateSQL);
//
//                    $loanBookSQLResult->execute();
//                    $updateBookSQLResult->execute();
//    $getLoanEndDateResult->execute();
                echo "<br>" . "<h2>Loan completed successfully <br>"; }
                } 
                else {header("Location:LogInPage.php"); 
                }}catch (PDOException $e) {
            die($e->getMessage());    
                }
                    ?>
                    <br><br>
                    <a class="btn btn-primary btn-default" href="index.php" role="button">Search for more books &raquo;</a>
                </div>
            </div>
            <?php require_once 'footer.php';?>
    </body>
</html>