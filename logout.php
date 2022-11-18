<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="pl" class="log">

<head>
    <title>QUIZ</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/quiz.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>    
    <link rel="stylesheet" href="css/style.css" />
</head>

<body class="log">
    <?php
		session_unset();
		session_destroy();
	?>
    <div id="overlay" class="min-vh-100">
        <div class="row align-items-center justify-content-center" style="height: 100vh">
            <div id="text" class="col-md-3">
                <div class="container" style="padding:30px;">
                    <div class="row align-items-start">
                        <div class="col-md-12">
                            <p>
                                Zostałeś wylogowany!
                            </p>
                        </div>
                    </div>
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <a class="btn btn-primary btn-lg btn-block" href="index.php" role="button">Wróć do strony
                                głównej</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>