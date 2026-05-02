<?php
/**
 * Run this ONCE to add role column to users table.
 * After running, you can set one user as admin in phpMyAdmin:
 * UPDATE users SET role = 'admin' WHERE email = 'your-admin@email.com';
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once 'Database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Check if role column exists
    $stmt = $conn->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($stmt->rowCount() === 0) {
        $conn->exec("ALTER TABLE users ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT 'user' AFTER password");
        echo "Column 'role' added. All existing users set to 'user'.<br>";
        $firstId = $conn->query("SELECT MIN(id) as id FROM users")->fetch(PDO::FETCH_ASSOC)['id'];
        if ($firstId) {
            $stmt = $conn->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
            $stmt->execute([$firstId]);
            echo "First user (ID $firstId) set as admin. You can change in phpMyAdmin: UPDATE users SET role = 'admin' WHERE email = 'your@email.com';<br>";
        }
    } else {
        echo "Column 'role' already exists. No changes made.<br>";
    }

    echo "<br><strong>Done.</strong> <a href='index.php'>Back to site</a> | <a href='login.php'>Login</a>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
