<link rel="stylesheet" href="styles.css">
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}
?>

<h1>Панель пользователя</h1>
<p>Добро пожаловать, пользователь!</p>
<a href="view_data.php">Просмотреть информацию</a><br>
<a href="logout.php">Выйти</a>