<?php
    session_start();
    require_once ('conn.php');
    require_once ('utils.php');

    if (empty($_GET['id']) || empty($_GET['roles'])) {
        die('Information is not completed.');
    }

    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    $id = $_GET['id'];
    $roles = $_GET['roles'];

    if (!$user || $user['roles'] !== "ADMIN") {
        header('Location: admin_index.php');
        exit;
    }

    $sql = "UPDATE peipei_users SET roles=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $roles, $id);
    
    
    $result = $stmt->execute();

    if (!$result) {
        die($conn->error);
    }
    header('Location: admin_index.php');
?>