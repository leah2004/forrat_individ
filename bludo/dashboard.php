<link rel="stylesheet" href="styles.css">
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}
?>

<h1>Панель администратора</h1>
<p>Добро пожаловать, администратор!</p>
<a href="add_data.php">Добавить информацию</a><br>
<a href="logout.php">Выйти</a>