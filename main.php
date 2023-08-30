<?php
require_once 'user.php';
require_once 'database.php';
require_once 'usermanagement.php';

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db';

// Create a UserManagement instance
$db = new Database($host, $username, $password, $database);
$userManager = new UserManagement($db);

// Initialize $user with empty values
$user = array(
    'id' => '',
    'username' => '',
    'email' => '',
    'role' => ''
);

try {
    // Example: Adding a new user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $result = $userManager->addUser($username, $email, $role);

        if ($result === true) {
            $message = "User added successfully!";
        } else {
            $message = "Error adding user.";
        }
    }

    // Retrieving user information by id
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        $user = $userManager->getUserById($user_id);
    }

    // Updating user information
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
        $user_id = $_POST['user_id'];
        $newUsername = $_POST['new_username'];
        $newEmail = $_POST['new_email'];
        $newRole = $_POST['new_role'];

        $result = $userManager->updateUser($user_id, $newUsername, $newEmail, $newRole);

        if ($result) {
            echo "User updated successfully!";
        } else {
            echo "Error updating user.";
        }
    }

    // Example: Deleting a user by id
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_user'])) {
        $user_id = $_GET['delete_user'];
        $result = $userManager->deleteUser($user_id);

        if ($result) {
            echo "User deleted successfully!";
        } else {
            echo "Error deleting user.";
        }
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>User Management</title>
</head>
<body>
    <div class="container">
    <h1>User Management</h1>

    <h2>Add User</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="role">Role:</label>
        <input type="text" name="role" id="role" required><br>
        <input type="submit" name="add_user" value="Add User">
    </form>
</div>
    <div id="addUserMessage">
        <?php if (isset($message)): ?>
            <?php echo $message; ?>
        <?php endif; ?>
    </div>
    <h2>Edit Profile</h2>
    <form method="post" action="">
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" id="user_id" value="<?php echo $user['id']; ?>" required><br>
        <label for="new_username">New Username:</label>
        <input type="text" name="new_username" id="new_username" value="<?php echo $user['username']; ?>" required><br>
        <label for="new_email">New Email:</label>
        <input type="email" name="new_email" id="new_email" value="<?php echo $user['email']; ?>" required><br>
        <label for="new_role">New Role:</label>
        <input type="text" name="new_role" id="new_role" value="<?php echo $user['role']; ?>" required><br>
        <input type="submit" name="update_user" value="Update Profile">
    </form>
    <h2>Delete User</h2>
    <form method="get" action="">
        <label for="delete_user">User ID to Delete:</label>
        <input type="number" name="delete_user" id="delete_user" required><br>
        <input type="submit" value="Delete User">
    </form>
</body>
</html>
