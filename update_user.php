<?php
    session_start();
    require_once ('conn.php');
    require_once ('utils.php');

    if (empty($_POST['nickname'])) {
        header('Location: index.php?errCode=1');
        die('Information is not completed.');
    }

    $username = $_SESSION['username'];
    $nickname = $_POST['nickname'];
    $sql = "UPDATE peipei_users SET nickname=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $nickname, $username);
    $result = $stmt->execute();

    if (!$result) {
        die($conn->error);
    }
    header('Location: index.php');
?>