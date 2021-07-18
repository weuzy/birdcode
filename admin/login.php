<?php require 'database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>les voyageurs</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/style.css">

</head>
<style>
    #admin{
        background: #fff;
        padding: 50px;
        width: 35%;
        border-radius: 10px;
    }
    button {
        width: 100%;
    }


</style>
<body>
<h1 class="text-logo"><span class="glyphicon glyphicon-leaf"></span>  Voyageurs <span
        class="glyphicon glyphicon-leaf"></span></h1>
<div class="container admin" id="admin">
    <div class="row">
        <h1 class="text-center"><strong>Connexion</strong></h1>
        <br>
        <?php
            $db = Database::connect();
            if (isset($_POST['btn'])) {
                $username = addslashes(strip_tags($_POST['username']));
                $pwd = addslashes(strip_tags($_POST['pwd']));

                if (!empty($username) AND !empty($pwd)) {
                    $sql = $db -> prepare('SELECT * FROM `users` WHERE  username = :username AND password = :pwd');
                    $sql -> execute(array('username' => $username, 'pwd' => $pwd));

                    if ($sql -> rowCount()) {
                        $data = $sql -> fetch();
                        $_SESSION['id'] = $data['id'];
                        $_SESSION['id'] = true;
                        header('location: index.php');
                    } else {
                        echo "<div class='alert alert-danger text-center'>nom d'utilisateur ou mot de passe est incorrect</div>";
                    }
                }else {
                    echo "<div class='alert alert-danger text-center'>Les champs sont obligatoire</div>";
                }
            }
        ?>
        <form class="form align-self-center" role="form" method="post" enctype="multipart/form-data" >
            <div class="form-group">
                <label for="name">Nom d'utilisateur:</label>
                <input type="text" class="form-control" id="name" name="username" placeholder="votre nom d'utilisateur...">
            </div>
            <div class="form-group">
                <label for="description">Mot de passe:</label>
                <input type="password" class="form-control" id="description" name="pwd" placeholder="votre mot de passe...">
            </div>
            <br>
            <div class="form-actions">
                <button type="submit" name="btn" class="btn btn-success text-center"><span class="glyphicon glyphicon-log-in"></span> Connexion</button>
            </div>
        </form>

    </div>
</div>
</body>
</html>
