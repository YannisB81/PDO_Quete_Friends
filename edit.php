<?php

require '_connec.php';

$pdo = new PDO(DSN, USER, PASS);

$friend = "";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $statement = $pdo->prepare("SELECT * FROM friend WHERE id=:id");
    $statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $statement->execute();
    $friend = $statement->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!empty($_POST['firstname']) && !empty($_POST['lastname'])) {
        // TRAITEMENT FORMULAIRE ICI (trim ...)
        $statement = $pdo->prepare("UPDATE story SET firstname=:firstname, lastname=:lastname WHERE id=:id");
        $statement->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $_POST['lastname'], PDO::PARAM_STR);
        $statement->bindValue(':id', $friend['id'], PDO::PARAM_INT);
        $statement->execute();
        
        header('Location: index.php#up_to_page');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Friend</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <form method="POST">
            <div class="mb-3">
                <label for="firstname" class="form-label">Title</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value=<?= $friend['firstname'] ?>>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Content</label>
                <textarea class="form-control" id="lastname" rows="3" name="lastname"><?= $friend['lastname'] ?></textarea>
            </div>
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </form>
    </div>
</body>

</html>
