<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Les Voyageurs</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/style.css">
</head>
<style>
    th,td {text-align: center;}
    .dec {
        margin-left: 45%;
        align-items: center;
    }
</style>

<body>
    <h1 class="text-logo"><span class="glyphicon glyphicon-leaf"></span>  Voyageurs <span
            class="glyphicon glyphicon-leaf"></span></h1>
    <div class="container admin">
        <div class="row">
            <h1 class="text-center">
                <a class="btn btn-warning btn-sm" type="submit" href="logout.php"><span class="glyphicon glyphicon-log-out"></span></a>
                <strong>Liste des Pigeons</strong>
                <a class="btn btn-success btn-sm" href="insert.php"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th class="hidden-xs hidden-sm">Nom</th>
                        <th class="hidden-xs hidden-sm">Description</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require 'database.php';
                        $db = Database::connect();
                        $statement = $db -> query("SELECT items.id, items.image, items.name, items.description, items.price, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC");
                        while ($item = $statement -> fetch()) {
                                echo '<td><img src="../images/' . $item['image'] .'" width="35" height="35" alt="..."></td>';
                                echo '<td class="hidden-xs hidden-sm">' . $item['name'] . '</td>';
                                echo '<td class="hidden-xs hidden-sm">' . $item['description'] . '</td>';
                                echo '<td>' . $item['price'] . ' f cfa</td>';
                                echo '<td>' . $item['category'] . '</td>';
                                echo '<td width=300 >';
                                    echo '<a href="view.php?id=' .$item['id'] .'" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> <small class="hidden-xs hidden-sm">Voir</small></a>';
                                    echo ' ';
                                    echo '<a href="update.php?id=' .$item['id'] .'" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> <small class="hidden-xs hidden-sm">Modifier</small></a>';
                                    echo ' ';
                                    echo '<a href="delete.php?id=' .$item['id'] .'" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> <small class="hidden-xs hidden-sm">Supprimer</small></a>';
                                echo '</td>';
                            echo '</tr>';
                        }
                        Database::disconnect();

                    ?>
                </tbody>

            </table>
        </div>
    </div>


</body>

</html>
