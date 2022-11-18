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
    <title>QUIZ - Rejetracja</title>
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
                            <a class="nav-link" href="top10.php">TOP 10</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gallery.php">Tapety</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="registration.php">Rejestracja</a>
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
            <div class="row justify-content-center mt-5" style="margin-bottom: 3rem;">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card shadow">
                        <div class="card-title text-center border-bottom">
                            <h2 class="p-3">Rejestracja</h2>
                        </div>
                        <div class="card-body">
                            <form action="registration.php" method="POST">
                                <div class="mb-4">
                                    <label for="login" class="form-label">Login</label>
                                    <input type="text" class="form-control" id="login" name="login" required/>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required/>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Hasło</label>
                                    <input type="password" class="form-control" id="password" name="password" required/>
                                </div>   
                                <div class="mb-4">
                                    <label for="name" class="form-label">Imie</label>
                                    <input type="text" class="form-control" id="name" name="name" required/>
                                </div>                              
                                <div class="mb-4">
                                    <label for="surname" class="form-label">Nazwisko</label>
                                    <input type="text" class="form-control" id="surname" name="surname" required/>
                                </div>
                                <div class="mb-4" style="text-align:center;">
                                    <p id="information" style="font-weight:bold;color:red;"><?php
                                        if(isset($_POST['register'])){
                                            // sprawdzamy czy login nie jest już w bazie
                                            $temp = false;//zmienna pomocnicza
                                            $sql = "SELECT `login` FROM users";
                                            $results=$conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($results as $record){
                                                if($record['login'] == $_POST['login'])//jeśli taki login już istnieje
                                                {
                                                    $temp = true;
                                                    echo 'Użytkownik o takim loginie już istnieje!';
                                                }
                                            }
                                    
                                            if($temp != true){
                                                $login= $_POST['login'];
                                                $password= $_POST['password'];
                                                $name= $_POST['name'];
                                                $surname= $_POST['surname'];
                                                $email= $_POST['email'];
                                                $correct = 0;
                                                $incorrect = 0;
                                                $password=hash('ripemd160',$password);
                                                $sqlaction=$conn->prepare("INSERT INTO users (login,password, name, surname, email, correctCount, incorrectCount) VALUES (:login,:password, :name, :surname, :email, :correct, :incorrect)");
                                                $sqlaction->bindValue(':login',$login);
                                                $sqlaction->bindValue(':password',$password);
                                                $sqlaction->bindValue(':name',$name);
                                                $sqlaction->bindValue(':surname',$surname);
                                                $sqlaction->bindValue(':email',$email);
                                                $sqlaction->bindValue(':correct',$correct);
                                                $sqlaction->bindValue(':incorrect',$incorrect);
                                                if ($sqlaction->execute()==true){
                                                    echo "Dodano nowego usera";
                                                }else{
                                                    echo "Wystąpił błąd".$conn->error;
                                                } 
                                            }   
                                            echo "<script>window.location.href = '#information'</script>";//skrypt przenoszący nas do komunikatu    
                                        }
                                    ?></p>
                                </div>
                                <div class="d-grid">
                                    <input id="register" type="submit" name="register" class="btn btn-primary mb-2" value="Zarejestruj">
                                </div>
                            </form>
                        </div>
                    </div>
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