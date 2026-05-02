<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include_once 'Database.php';
include_once 'User.php';

$db = new Database();
$conn = $db->getConnection();
$user = new User($conn);
$users = $user->getAllUsers();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_role'])) {
    $userId = (int) $_POST['user_id'];
    $newRole = $_POST['role'] === 'admin' ? 'admin' : 'user';
    if ($user->setUserRole($userId, $newRole)) {
        $message = 'Roli u Perdisua';
        $users = $user->getAllUsers();
    } else {
        $message = 'Roli nuk u perdisua';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - DiceRoll</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="dashboard-header">
            <div>
                <h1>Admin Dashboard</h1>
            </div>
            <a href="index.php" class="back-link">←</a>
        </div>

        <?php if ($message): ?>
            <div class="msg"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <h2>Useri</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Date of birth</th>
                    <th>Role</th>
                    <th>Ndrysho rolin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?php echo (int) $u['id']; ?></td>
                    <td><?php echo htmlspecialchars($u['username'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td><?php echo htmlspecialchars($u['dateofbirth'] ?? '-'); ?></td>
                    <td>
                        <span class="badge badge-<?php echo ($u['role'] ?? 'user') === 'admin' ? 'admin' : 'user'; ?>">
                            <?php echo htmlspecialchars($u['role'] ?? 'user'); ?>
                        </span>
                    </td>
                    <td>
                        <form class="role-form" method="post">
                            <input type="hidden" name="user_id" value="<?php echo (int) $u['id']; ?>">
                            <select name="role">
                                <option value="user" <?php echo ($u['role'] ?? '') === 'user' ? 'selected' : ''; ?>>User</option>
                                <option value="admin" <?php echo ($u['role'] ?? '') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                            <button type="submit" name="change_role">Ruaj</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>
</html>
