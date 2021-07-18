<?php
    require 'database.php';
   
    // Protection contre les Hackers sur les inputs
    if (!empty( $_GET['id'])) {
        $id = checkInput($_GET['id']);
    }
    $nameError = $descriptionError = $priceError = $imageError =$categoryError = $name = $description = $image = $category = $price = "";
     if (!empty($_POST)) {
         $name              = checkInput($_POST['name']);
         $description       = checkInput($_POST['description']);
         $price             = checkInput($_POST['price']);
         $category          = checkInput($_POST['category']);
         $image              = checkInput($_FILES['image']['name']);
         $imagePath         = '../images/' . basename($image);
         $imageExtension    = pathinfo($imagePath, PATHINFO_EXTENSION);
         $isSuccess        = true;

         if (empty($name)) {
             $nameError = 'le nom est obligatoire';
             $isSuccess = false;
         }
         if (empty($description)) {
            $descriptionError = 'la description  est obligatoire';
            $isSuccess = false;
         }
         if (empty($price)) {
            $priceError = 'le prix est obligatoire';
            $isSuccess = false;
         }
         if (empty($category)) {
            $categoryError = 'la catégorie est obligatoire';
            $isSuccess = false;
         }
         if (empty($image)) {
            $imageUpdated = false;
         }
         else{
             $imageUpdated = true;
             $isUploadSuccess = true;
             if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") {
                 $imageError = "Les fichiers autorisés sont: .png, .jpeg, .jpg et .gif";
                 $isSuccess = false;
             }
             if (file_exists($imagePath)) {
                 $imageError = "Le fichier existe déjà";
                 $isSuccess = false;
             }
             if ($_FILES['image']['size'] > 500000) {
                 $imageError = "Le fichier ne doit pas dépasser les 500KB";
                 $isSuccess = false;
             }

         }
         if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) {
             $db = Database:: connect();
             if ($isImageUpdated) {
                 $statement = $db -> prepare("UPDATE items set name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?");
                 $statement -> execute(array($name, $description, $price, $category, $image, $id));
             }
             else{
                 $statement = $db -> prepare("UPDATE items set name = ?, description = ?, price = ?, category = ? WHERE id = ?");
                 $statement -> execute(array($name, $description, $price, $category, $id));
             }
             Database::disconnect();
             header("location: index.php");
         }
         else if ($isImageUpdated && !$isUploadSuccess) {
             $db = Database::connect();
             $statement = $db -> prepare("SELECT image FROM items WHERE id = ?");
             $statement -> execute(array($id));
             $item = $statement -> fetch();
             $image =  $item['image'];

             Database::disconnect();
         }
     }
     else{
         $db = Database::connect();
         $statement = $db -> prepare("SELECT * FROM items WHERE id = ?");
         $statement -> execute(array($id));
         $item = $statement -> fetch();
         $name           =  $item['name'];
         $description    =  $item['description'];
         $price          =  $item['price'];
         $category       =  $item['category'];
         $image          =  $item['image'];

         Database::disconnect();
     }

     function checkInput($data){
        $data = trim ($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }





?>



<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Les voyageurs</title>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
            <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="../css/style.css">
            
        </head>
        <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-leaf"></span>  Voyageurs <span
                    class="glyphicon glyphicon-leaf"></span></h1>
        <div class="container admin">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="text-center"><strong>Modifier les détails d'un Pigeon</strong></h1>
                        <br>
                        <form action="<?php echo 'update.php?id=' .$id; ?>" role="form" class="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="name">Nom:</label>
                              <input type="text" name="name" id="name" class="form-control" placeholder="Nom" value="<?php echo $name ?>">
                              <span class="help-inline"><?php echo $nameError ?></span>
                            </div>
                            <div class="form-group">
                              <label for="description">Description:</label>
                              <input type="text" name="description" id="description" class="form-control" placeholder="Description" value="<?php echo $description ?>">
                              <span class="help-inline"><?php echo $descriptionError ?></span>
                            </div> 
                            <div class="form-group">
                              <label for="price">Prix (en f cfa):</label>
                              <input type="text" name="price" id="price" class="form-control" placeholder="Prix" value="<?php echo $price ?>">
                              <span class="help-inline"><?php echo $priceError ?></span>
                            </div>
                            <div class="form-group">
                              <label for="category">Category:</label>
                              <select name="category" id="category" class="form-control">
                                  <?php
                                       $db = Database::connect();
                                       foreach ($db -> query('SELECT * FROM categories') as $row) {
                                           if ($row['id'] == $category) 
                                           echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                           else 
                                           echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                       }
                                       Database::disconnect();
                                  ?>
                              </select>
                              <span class="help-inline"><?php echo $categoryError; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Image:</label>
                                <p><?php echo $image ?></p>
                                <label for="image">selectionner une image</label>
                                <input type="file" name="image" id="image">
                                <span class="help-inline"><?php echo $imageError ?></span>
                            </div>
                            <br>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Enregistrer la modification</button>
                                <a href="index.php" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <div class="thumbnail">
                            <img src="<?php echo '../images/' . $image; ?>" alt="..." >
                            <div class="price"><?php echo $price. ' f cfa' ?></div>
                            <div class="caption">
                                <h4><?php echo $name; ?></h4>
                                <p><?php echo $description; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>
