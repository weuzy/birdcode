<?php
    class Main {
        private $db;
        function __construct($db) {
            $this -> _db = $db;
        }
        function login() {
            if (isset($_POST['btn'])) {
                $username = addslashes(strip_tags($_POST['username']));
                $pwd = addslashes(strip_tags($_POST['pwd']));

                if (!empty($username) AND !empty($pwd)) {
                    $sql = $this -> _db -> prepare('SELECT * FROM `users` WHERE  username = :username AND password = :pwd');
                    $sql -> execute(array('username' => $username, 'pwd' => $pwd));

                    if ($sql -> rowCount()) {
                        $data = $sql -> fetch();
                        $_SESSION['id'] = $data['id'];
                        $_SESSION['id'] = true;
                        header('location: index.php');
                    }
                }else {
                    echo "<div class='alert alert-danger'>le nom d\'utilisateur ou  le mot de passe est incorrect</div>";
                }
            }
        }
    }
