<?php
include "database.php";

    if ($_SESSION['id'] == false) {
        header('location: index.php');
    }
