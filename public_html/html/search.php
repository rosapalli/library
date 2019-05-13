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
        <link rel="stylesheet" href="../css/stylesheet.css">
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
        ?>
        <?php
        $dsn = 'mysql:host=localhost;dbname=library2';
        $user = 'root';
        $pass = '';

        try {
            $pdo = new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        ?>

        <div id="container2" class="container">
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <h1>
                        <?php
                        if (isset($_POST['nsubmit'])) {
                            $input_search = filter_var($_POST['search_book'], FILTER_SANITIZE_STRING);
                            $q = filter_var($_POST['search_book'], FILTER_SANITIZE_STRING);
                            $q2 = "%$q%"; //created a new variable with wildcard perameters
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $search = $pdo->prepare(
                                    "SELECT BOOK.book_ID, title, first_name, last_name, pages, image, publish_date, status
        FROM Book 
        INNER JOIN book_author 
        ON book.book_ID = book_author.book_ID 
        INNER JOIN author 
        ON book_author.author_ID = author.author_ID
        WHERE book.title LIKE :title OR author.first_name LIKE :fname OR author.last_name LIKE :lname");

                            try {
                                $search->execute(array(
                                    ':lname' => $q2, //updated to the new variable which contains wildcards
                                    ':fname' => $q2,
                                    ':title' => $q2,
                                ));
                                $row_cnt = $search->rowCount();
                                if ($row_cnt == 0) {
                                    echo "There are no results.";
                                } else {
                                    $rmsg = $row_cnt . " result(s)";
                                    foreach ($search as $s) {
                                        echo "<p><b>" . $s['title'] . "</b><br>Author: " . $s['first_name'] . " " . $s['last_name'] . "<br>Date published: " . $s['publish_date'] . "<br>Pages: " . $s['pages'] . "<br>Status: <b>" . $s['status'] . "</b><br>" . $s['image'] . "</p>";
                                        echo "<br>";
                                        if ($s['status'] == "on shelf") {
                                            $url = "http://localhost/LibraryWebsite/public_html/html/borrowBook.php?bookID=" . $s['book_ID'];
                                            $bookID = $s['book_ID'];
                                            echo "<form action='$url'><input type='hidden' name='bookID' value='$bookID'><button type='submit' method = 'GET'>Borrow this book</button></form>";
                                        }
                                    }
                                }
                            } catch (PDOException $e) {
                                die($e->getMessage());
                            }
                        }

                        if (isset($_POST['submit'])) {
                            if (in_array('title', $_POST['opt'])) {
                                $input_search = filter_var($_POST['srch-term'], FILTER_SANITIZE_STRING);
                                $q = filter_var($_POST['srch-term'], FILTER_SANITIZE_STRING);
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $search = $pdo->prepare("SELECT BOOK.book_ID, title, first_name, last_name, pages, image, publish_date, status
                    FROM Book 
                    INNER JOIN book_author 
                    ON book.book_ID = book_author.book_ID 
                    INNER JOIN author 
                    ON book_author.author_ID = author.author_ID
                    WHERE title LIKE ?");
                                try {
                                    $search->execute(array("%$q%"));
                                    $row_cnt = $search->rowCount();
                                    if ($row_cnt == 0) {
                                        echo "There are no results.";
                                    } else {
                                        $rmsg = $row_cnt . " result(s)";
                                        foreach ($search as $s) {
                                            echo "<p><b>" . $s['title'] . "</b><br>Author: " . $s['first_name'] . " " . $s['last_name'] . "<br>Date published: " . $s['publish_date'] . "<br>Pages: " . $s['pages'] . "<br>Status: <b>" . $s['status'] . "</b><br>" . $s['image'] . "</p>";
                                            echo "<br>";
                                            if ($s['status'] == "on shelf") {
                                                $bookID = $s['book_ID'];
                                                $url = "http://localhost/LibraryWebsite/public_html/html/borrowBook.php?bookID=" . $s['book_ID'];
                                                echo "<form action='$url'><input type='hidden' name='bookID' value='$bookID'><button type='submit' method = 'GET'>Borrow this book</button></form>";
                                            }
                                        }
                                    }
                                } catch (PDOException $e) {
                                    die($e->getMessage());
                                }
                            }

                            if (in_array('author', $_POST['opt'])) {
                                $input_search = filter_var($_POST['srch-term'], FILTER_SANITIZE_STRING);
                                $q = filter_var($_POST['srch-term'], FILTER_SANITIZE_STRING);
                                $q2 = "%$q%"; //created a new variable with wildcard perameters
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $search = $pdo->prepare("SELECT BOOK.book_ID, title, first_name, last_name, pages, image, publish_date, status
                    FROM Book 
                    INNER JOIN book_author 
                    ON book.book_ID = book_author.book_ID 
                    INNER JOIN author 
                    ON book_author.author_ID = author.author_ID
                    WHERE author.first_name = :fname OR author.last_name = :lname");

                                try {
                                    $search->execute(array(
                                        ':fname' => $q2,
                                        ':lname' => $q2,
                                    ));
                                    $row_cnt = $search->rowCount();
                                    if ($row_cnt == 0) {
                                        echo "There are no results.";
                                    } else {
                                        $rmsg = $row_cnt . " result(s)";
                                        foreach ($search as $s) {
                                            echo "<p><b>" . $s['title'] . "</b><br>Author: " . $s['first_name'] . " " . $s['last_name'] . "<br>Date published: " . $s['publish_date'] . "<br>Pages: " . $s['pages'] . "<br>Status: <b>" . $s['status'] . "</b><br>" . $s['image'] . "</p>";
                                            echo "<br>";
                                            if ($s['status'] == "on shelf") {
                                                $bookID = $s['book_ID'];
                                                $url = "http://localhost/LibraryWebsite/public_html/html/borrowBook.php?bookID=" . $s['book_ID'];
                                                echo "<form action='$url'><input type='hidden' name='bookID' value='$bookID'><button type='submit' method = 'GET'>Borrow this book</button></form>";
                                            }
                                        }
                                    }
                                } catch (PDOException $e) {
                                    die($e->getMessage());
                                }
                            }
                        }
                        ?> 
                    </h1>
                </div>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        ?> 
    </body>
</html>