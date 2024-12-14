<link rel="stylesheet" href="styles.css">
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role_id = $_SESSION['role_id'];
?>

<h1>Выбор действий</h1>
<?php if ($role_id == 1): // Первый пользователь ?>
    <a href="view_data.php">Просмотреть данные</a><br>
    <a href="fill_data.php">Заполнить данные</a>
<?php else: // Второй пользователь ?>
    <a href="view_data.php">Просмотреть данные</a>
<?php endif; ?>
<a href="logout.php">Выйти</a>