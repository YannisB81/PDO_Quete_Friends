<?php
require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);


$statement = $pdo->query("SELECT * FROM friend");
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);

// CREATE ARTICLE 

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!empty($_POST['firstname']) && !empty($_POST['lastname'])) {
        if (strlen($_POST['firstname']) <= 45 && strlen($_POST['lastname']) <= 45) {
            // TRAITEMENT FORMULAIRE ICI (trim ...)
            $statement = $pdo->prepare("INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)");
            $statement->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
            $statement->bindValue(':lastname', $_POST['lastname'], PDO::PARAM_STR);
            $statement->execute();
            
            header('Location: index.php#up_to_page');
        } else {
            echo "45 caractères maximum par champs";
        }
    } else {
        echo "Tous les champs sont requis !";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

</head>
<body>
<h1 class="title text-center" id="up_to_page">FRIENDS</h1>
    
    <div class="friends-list">
        <ul>
            <br><br><br><br><br><br><br>
            <?php foreach ($friends as $friend) {
                ?><li><?= $friend['firstname']." ".$friend['lastname']?>
                    <a href=<?="edit.php?id=".$friend['id'] ?> class="btn btn-success">Edit</a>
                    <a href=<?= "delete.php?id=".$friend['id'] ?> class="btn btn-danger">Delete</a>
                </li>
            
            <?php } ?>
            <br><br><br><br><br><br><br>
        </ul>
    </div>
    <div class="container">
        <form method="POST">
            <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" id="firstname" name="firstname">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" id="lastname" name="lastname">
            </div>
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</body>
</html>