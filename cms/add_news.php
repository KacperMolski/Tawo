<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db.php';

    $date = $_POST['date'];
    $title = $_POST['title'];
    $description = $_POST['desc'];

    $uploadsDirectory = '../img/uploads/';
    $fileUploadsDirectory = 'img/uploads/';
    $imagePaths = [];

    if (!file_exists($uploadsDirectory)) {
        mkdir($uploadsDirectory, 0777, true);
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (isset($_FILES['images']) && is_array($_FILES['images']['tmp_name'])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $fileName = $_FILES['images']['name'][$key];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExtension, $allowedExtensions)) {
                $targetPath = $uploadsDirectory . basename($fileName);
                $fileTargetPath = $fileUploadsDirectory . basename($fileName);
                move_uploaded_file($tmpName, $targetPath);
                $imagePaths[] = $fileTargetPath;
            }
        }
    }

    $imagesJson = json_encode($imagePaths);

    $insertStmt = $db->prepare("INSERT INTO news (date, title, description, images) VALUES (:date, :title, :description, :images)");
    $insertStmt->bindParam(':date', $date);
    $insertStmt->bindParam(':title', $title);
    $insertStmt->bindParam(':description', $description);
    $insertStmt->bindParam(':images', $imagesJson);

    if ($insertStmt->execute()) {
        session_regenerate_id();
        header("Cache-Control: no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Location: home.php");
    } else {
        echo "Wystąpił błąd podczas dodawania wiadomości.";
    }
}
?>