<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styl.css">
    <link rel="stylesheet" href="../media-1024.css">
    <link rel="stylesheet" href="../media-768.css">
    <link rel="shortcut icon" href="../img/icons/favicon.jpg" type="image/x-icon">
    <title>Home</title>
</head>

<body>
<div class="logo-cms">
            <img src="../img/icons/logo.png" alt="Logo">
            <h2>Witaj w panelu aktualności</h2>
        </div>
      
    <div class="row">
    <div class="container-home">
  
  <div class="home-content">
      <h2>Dodaj aktualności</h2>
      <form action="add_news.php" method="POST" enctype="multipart/form-data">
          <label for="date">Data:</label>
          <input type="date" id="date" name="date" required>
          <label for="title">Tytuł:</label>
          <input type="text" id="title" name="title" required>
          <label for="desc">Opis:</label>
          <textarea name="desc" id="desc" cols="30" rows="10"></textarea>
          <label for="desc">Zdjęcia:</label><br>
          <input  style="background-color: #457b9d" type="file" name="images[]" multiple accept="image/*">
          <button type="submit">Dodaj</button>
      </form>

  </div>
  
</div>
<div class="container-home-news">
 
  <div class="home-content">
      <h2>Panel aktualności</h2>
      <?php
        require_once 'db.php';

        if (isset($_GET['delete'])) {
            $idToDelete = $_GET['delete'];
            $deleteStmt = $db->prepare("DELETE FROM news WHERE id = :id");
            $deleteStmt->bindParam(':id', $idToDelete);

            if ($deleteStmt->execute()) {
                echo "Wiadomość o ID $idToDelete została usunięta.";
            } else {
                echo "Wystąpił błąd podczas usuwania wiadomości.";
            }
        }

        $newsQuery = $db->query("SELECT id, date, title FROM news ORDER BY date DESC");

        if ($newsQuery) {
            echo "<ul class='news-list'>";
            foreach ($newsQuery as $news) {
                echo "<li class='news-item'>";
                echo "<strong>Tytuł:</strong> " . $news['title'] . " ";
                echo "<strong>Data:</strong> " . $news['date'] . " ";
                echo "<a class='news-delete-link' href='home.php?delete=" . $news['id'] . "'>Usuń</a>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "Brak wiadomości do wyświetlenia.";
        }
        ?>
      
  </div>
  
</div>

    </div>
    <form action="logout.php" method="POST">
          <button style="background-color: #d62828;   width: 40%;
  padding: 10px;
  margin: 10px 30%;
  color: #fff;
  border: none;
  border-radius: 3px;
  cursor: pointer;" type="submit">Wyloguj</button>
      </form>
</body>

</html>
