<?php
// Kommentar speichern
if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    file_put_contents('comments.txt', $comment . "\n", FILE_APPEND);
    header("Location: index.php");
    exit;
}

// Kommentare laden
$comments = file_exists('comments.txt') ? file('comments.txt', FILE_IGNORE_NEW_LINES) : [];
?>



<h2>Gästebuch:</h2>
<?php foreach ($comments as $c): ?>
  <p><?= $c ?></p>
<?php endforeach; ?>

<form method="post">
  <label for="comment">Kommentar:</label><br>
  <textarea name="comment" rows="4" cols="40"></textarea><br>
  <button type="submit">Speichern</button>
</form>