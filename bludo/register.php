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

$message = ""; // Переменная для сообщения

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хэширование пароля
    $role_id = $_POST['role_id']; // Получаем роль из формы

    // Проверка на существование пользователя
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Вставка нового пользователя
        $stmt = $conn->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $username, $password, $role_id);
        
        if ($stmt->execute()) {
            $message = "Регистрация успешна! Теперь вы можете войти.";
        } else {
            $message = "Ошибка при регистрации: " . $stmt->error; // Выводим ошибку
        }
    } else {
        $message = "Пользователь с таким именем уже существует.";
    }
}
?>

<h1>Регистрация</h1>
<form method="POST">
    Имя пользователя: <input type="text" name="username" required><br>
    Пароль: <input type="password" name="password" required><br>
    Роль:
    <select name="role_id" required>
        <option value="1">Администратор</option>
        <option value="2">Пользователь</option>
    </select><br>
    <input type="submit" value="Зарегистрироваться">
</form>

<?php if ($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>