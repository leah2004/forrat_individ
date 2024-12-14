<link rel="stylesheet" href="styles.css">
<?php
session_start();
$conn = new mysqli('127.0.0.1', 'root', '', 'user_management');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dish_name = $_POST['dish_name'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    // Проверка и создание папки uploads, если она не существует
    $target_dir = __DIR__ . "/uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Путь для сохранения файла
    $target_file = $target_dir . basename($image["name"]);

    // Перемещение загруженного файла
    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO data (user_id, dish_name, description, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $dish_name, $description, $target_file);
        $stmt->execute();
        echo "Блюдо успешно добавлено!";
    } else {
        echo "Ошибка при загрузке файла.";
    }
}
?>

<h1>Добавить блюдо</h1>
<form method="POST" enctype="multipart/form-data">
    Название блюда: <input type="text" name="dish_name" required><br>
    Описание: <textarea name="description" required></textarea><br>
    Изображение: <input type="file" name="image" accept="image/*" required><br>
    <input type="submit" value="Добавить">
</form>