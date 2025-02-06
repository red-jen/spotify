<?php
// Include the database configuration
$config = include 'config.php';

// Connection string
$dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

try {
    // Create a PDO instance (PHP Data Object)
    $pdo = new PDO($dsn, $config['user'], $config['password']);

    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to the database successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}









// Create a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    try {
        $sql = "INSERT INTO users (username, email, password_hash, role) 
                VALUES (:username, :email, :password_hash, :role)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password_hash' => $password_hash,
            ':role' => $role
        ]);
        echo "User created successfully!";
    } catch (PDOException $e) {
        echo "Error creating user: " . $e->getMessage();
    }
}

// Fetch all users
try {
    $sql = "SELECT * FROM users";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching users: " . $e->getMessage());
}
?>

<!-- HTML Form to Create a User -->
<form method="POST" action="">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="role">
        <option value="user">User</option>
        <option value="artist">Artist</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit" name="create">Create User</button>
</form>

<!-- Display Users -->
<h2>Users</h2>
<ul>
    <?php foreach ($users as $user): ?>
        <li>
            ID: <?= $user['id'] ?>, 
            Username: <?= $user['username'] ?>, 
            Email: <?= $user['email'] ?>, 
            Role: <?= $user['role'] ?>
        </li>
    <?php endforeach; ?>
</ul>