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
    <title>QUIZ - test</title>
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
    <title>QUIZ - Test</title>
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
        <div class="container-fluid min-vh-100">
            <form action="score.php" method="POST">
                <?php
                    $sql = "SELECT * FROM pytania";
                    $results=$conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                    $i=1;//numer pytania wyświetlany
                    $usedquest = array();//tablica w której id użytych pytań
                    $qnumber = 0; //pomocnicza do numeracji pytań
                foreach($results as $record){
                        array_push($usedquest, $record['id']);//dodaje id pytania do tablicy
                    }
                    foreach($results as $result){
                        $mod = $i%2;
                        if($mod==0) echo '<div class="row" style="background: #f2f2f2;">';
                        else echo '<div class="row" style="background: white;">';
                        echo '<div class="col-md-12" style="text-align:left;padding:1rem;"><b>'.$i.'. '.$result['pytanie'].':</b></div></div>';
                                if($mod==0) echo '<div class="row justify-content-center" style="padding:3rem; background: #f2f2f2;">';
                                else echo '<div class="row justify-content-center" style="padding:3rem; background: white;">';
                                    echo'<div class="col-12"> 
                                                    <input class="form-check-input" type="radio" name="'.$qnumber.'" id="gridRadios1"
                                                        value="A" checked="checked">
                                                    <label class="form-check-label" for="gridRadios1">
                                                        '.$result['a'].'
                                                    </label>
                                        </div>
                                        <div class="col-12"> 
                                                    <input class="form-check-input" type="radio" name="'.$qnumber.'" id="gridRadios2"
                                                        value="B">
                                                    <label class="form-check-label" for="gridRadios2">
                                                        '.$result['b'].'
                                                    </label>
                                        </div>
                                        <div class="col-12"> 
                                                    <input class="form-check-input" type="radio" name="'.$qnumber.'" id="gridRadios3"
                                                        value="C">
                                                    <label class="form-check-label" for="gridRadios3">
                                                        '.$result['c'].'
                                                    </label>
                                        </div>
                                        <div class="col-12"> 
                                                    <input class="form-check-input" type="radio" name="'.$qnumber.'" id="gridRadios4"
                                                        value="D">
                                                    <input type="hidden" name="q'.$qnumber.'" id="gridHid"
                                                        value="'.$usedquest[$qnumber].'">'; //w value id pytania z tablicy w bazie
                                                    echo '<label class="form-check-label" for="gridHid">
                                                        '.$result['d'].'
                                                    </label>
                                                    <input type="hidden" name="login" value="'.$_SESSION['login'].'">';
                                        echo '</div></div>';
                                    ++$i;
                                    ++$qnumber;//zwiększamy pomocnicze zmienne
                    }
                ?>
                <div class="row justify-content-center" style="padding:2rem;">
                    <div class="col-12 col-sm-6 col-md-4" style="padding:0;">
                        <input id="check" type="submit" name="check" class="btn btn-primary mb-2"
                            value="Sprawdź swój wynik" style="width:100%;"/>
                    </div>
                </div>
            </form>
        </div>

        <!-- FOOTER -->
        <footer class="py-5">
            <p class="m-0 text-center">Copyright &copy; Dawid Kogut 2021</p>
        </footer>
    </main>
</body>

</html>