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

    if(!isset($_SESSION['login'])){
        echo '
        <!DOCTYPE html>
        <html lang="pl" class="log">
        
        <head>
            <title>QUIZ - twój wynik</title>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" type="image/png" href="images/quiz.png" />
            <link rel="stylesheet" href="css/style.css" />
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>    
        </head>
        
        <body class="log">
            <div id="overlay">
                <div class="row align-items-center justify-content-center" style="height: 100vh">
                    <div id="text" class="col-md-3">
                        <div class="container" style="padding:30px;">
                            <div class="row align-items-start">
                                <div class="col-md-12">
                                    <p>
                                        Nie jesteś zalogowany!
                                    </p>
                                </div>
                            </div>
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                <a class="btn btn-primary btn-lg btn-block" href="index.php" role="button">Wróć do strony głównej</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </body>
        
        </html>
                ';
        die;
    }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <title>QUIZ - twój wynik</title>
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
                            <a class="nav-link active" href="tests.php">Test</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="top10.php">TOP 10</a>
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
        <div class="container min-vh-100">
            <div class="row justify-content-center">
                <div class="col-md-6" style="text-align:center; padding:3rem;">
                    <?php
                        if (isset($_POST['check'])){
                            $pyt = array();//tabela z  pytaniami jakie miał użytkownik
                            $odp = array();//tabela z odpowiedziami użytkownika
                            $iledobrych = 0; //ile dobrych w tej grze
                            $ilezlych = 0; //ile złych w tej grze
                            $userCorrect = 0;
                            $userIncorrect = 0;
                            $pom = 0;
                            while($pom < 20){//uzupełniamy pytaniami jakie miał użytkownik
                                $pyt[$pom] = $_POST['q'.$pom];
                                $pom++;
                            }
                    
                            $pom = 0;
                            while($pom < 20){//uzupełniamy odpowiedzi jakie zaznaczył użytkownik
                                $odp[$pom] = $_POST[$pom];
                                $pom++;
                            }
                    
                            $pom = 0;
                            while($pom < 20){
                                $sql = "SELECT * FROM pytania WHERE id = ".$pyt[$pom]."";
                                $results=$conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                                //$ra = $conn->query("SET NAMES utf8");//polskie znaki
                                //$ra = $conn->query("SELECT * FROM pytania WHERE id = ".$pyt[$pom]."");
                                foreach($results as $rec){
                                    if($rec['odpowiedz'] == $odp[$pom]){//jeśli odpowiedz była dobra
                                        $iledobrych++;
                                        $ra4 = $conn->query('UPDATE `pytania` SET `correctAnswers`=`correctAnswers` + 1 WHERE id ="'.$pyt[$pom].'"');
                                    }
                                    else{
                                        $ilezlych++;
                                        $ra5 = $conn->query('UPDATE `pytania` SET `incorrectAnswers`=`incorrectAnswers` + 1 WHERE id ="'.$pyt[$pom].'"');
                                    }
                                }
                                $pom++;
                            }
                            $sql2 = 'SELECT * FROM users WHERE login = "'.$_SESSION['login'].'"';
                            $results2=$conn->query($sql2)->fetchAll(PDO::FETCH_ASSOC);
                            foreach($results2 as $rec){
                                $userCorrect = $rec['correctCount'];
                                $userIncorrect = $rec['incorrectCount'];
                            }
                            $userCorrect += $iledobrych;
                            $userIncorrect += $ilezlych;
                            $sql3='UPDATE `users` SET `correctCount`="'.$userCorrect.'",`incorrectCount`="'.$userIncorrect.'" WHERE login="'.$_SESSION['login'].'"';
                            //$results3=$conn->query($sql3)->fetchAll(PDO::FETCH_ASSOC);
                            $conn->prepare($sql3);
                            echo "<p style='color:green;font-weight:bold'>Poprawnych odpowiedzi: <span id='good'>".$iledobrych."</span></p>";
                            echo "<p style='color:red;font-weight:bold'>Złych odpowiedzi: <span id='bad'>".$ilezlych."</span></p>";
                            $procent = ($iledobrych / 20) * 100;
                            echo "<p style='color:blue;font-weight:bold'>Uzyskałeś: ".$procent."%</p>";
                            
                        }
                    ?>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <canvas id="myCanvas" height="300"></canvas>
                    <script src="javascript/script.js"></script> <!--SKRYPT OBSŁUGUJACY CANVASA-->
                </div>
            </div>
        </div>
         <!-- FOOTER -->
         <footer class="py-5">
            <p class="m-0 text-center">Copyright &copy; Dawid Kogut 2021</p>
        </footer>
    </main>
</body>

</html>