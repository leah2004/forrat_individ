<link rel="stylesheet" href="styles.css">
<?php
session_start();
$servername = "127.0.0.1"; // или ваш сервер
$username = "root"; // замените на ваше имя пользователя
$password = ""; // замените на ваш пароль
$dbname = "user_management"; // замените на имя вашей базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Получение данных пользователя
    $stmt = $conn->prepare("SELECT id, role_id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $role_id, $hashed_password);
        $stmt->fetch();

        // Проверка пароля
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role_id'] = $role_id;
            header("Location: actions.php");
            exit();
        } else {
            echo "Неверное имя пользователя или пароль.";
        }
    } else {
        echo "Неверное имя пользователя или пароль.";
    }
}
?>

<h1>Вход</h1>
<form method="POST">
    Имя пользователя: <input type="text" name="username" required><br>
    Пароль: <input type="password" name="password" required><br>
    <input type="submit" value="Войти">
</form>
