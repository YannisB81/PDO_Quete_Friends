
<?php

require '_connec.php';

$pdo = new PDO(DSN, USER, PASS);

// DELETE ONE ARTICLE
// DELETE FROM article WHERE id=:id

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $statement = $pdo->prepare("DELETE FROM friend WHERE id=:id");
    $statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $statement->execute();

    header('Location: index.php');
}