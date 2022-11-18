<?php
    session_start();

    require "dbconnect.php"; //wymagamy pliku z danymi logowania do bazy w przeciwnym razie przerywamy skrypt

    try {
        $conn = new PDO("mysql:host=localhost;dbname=$databasename;charset=utf8", $username, $password);
      // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //echo "Connected successfully";
    } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <title>QUIZ - TOP 10</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/quiz.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>    
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img src="images/quiz.png" height="48"
                        class="d-inline-block align-text-top" alt="logo" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Start</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tests.php">Test</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="top10.php">TOP 10</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gallery.php">Tapety</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registration.php">Rejestracja</a>
                        </li>
                    </ul>
                    <?php 
                       if(isset($_SESSION['login'])){
                        echo '<div class="h-100" style="padding-right:5px; color:#664B39;">Jesteś zalogowany jako <b><span style="color:#E5A097;">'.$_SESSION['login'].'</span></b></div>';
                        echo'<form class="d-flex" action="logout.php" method="POST">
                                <button id="buttonLog" class="btn btn-outline-success" type="submit">Wyloguj</button>
                            </form>';

                    }else{
                        echo'<form class="d-flex" action="login.php" method="POST">
                                <input class="form-control me-2 logInput" type="text" name="login" placeholder="Login" required>
                                <input class="form-control me-2 logInput" type="password" name="password" placeholder="Hasło" required>
                                <button id="buttonLog" class="btn btn-outline-success" type="submit">Zaloguj</button>
                            </form>';
                    }
	                ?>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="table-responsive col-lg-12 min-vh-100">
            <table class="table table-striped table-hover table-borderless" style="text-align:center;">
                <thead>
                    <tr>
                        <th scope="col">Miejsce</th>
                        <th scope="col">Nick</th>
                        <th scope="col">Punkty</th>
                    </tr>
                </thead>
                <tbody>
                            <?php
                                $sql = "SELECT login, correctCount, incorrectCount, correctCount-incorrectCount FROM users ORDER BY 4 desc";//sortowanie po wyrażeniu correctCount-incorrectCount
                                $results=$conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                                $place=1;//zmienna pomocnicza do numeracji miejsca
                                foreach($results as $record){
                                    $score = $record['correctCount'] - $record['incorrectCount'];
                                    echo'
                                    <tr>
                                        <th scope="row" style="font-weight:bold;">'.$place++.'</th>
                                        <td style="color:#88B0B3;">'.$record['login'].'</td>
                                        <td style="color:#88B0B3;">'.$score.'</td>
                                    </tr>
                                    ';
                                }
                            ?>
                </tbody>
            </table>
        </div>

        <!-- FOOTER -->
        <footer class="py-5">
            <p class="m-0 text-center">Copyright &copy; Dawid Kogut 2021</p>
        </footer>
    </main>
</body>

</html>