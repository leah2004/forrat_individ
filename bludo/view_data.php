<link rel="stylesheet" href="styles.css">
<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM data");
?>

<h1>Рецепты</h1>
<div class="recipes">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="recipe">
            <h2><?php echo $row['dish_name']; ?></h2>
            <p><?php echo $row['description']; ?></p>
            <?php if ($row['image_path']): ?>
                <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['dish_name']; ?>" style="max-width: 300px;">
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

<?php
$conn->close();
?>