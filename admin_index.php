<?php
    session_start(); 
    require_once('conn.php'); 
    require_once('utils.php');

    $username = NULL;
    $user = NULL;
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $user = getUserFromUsername($username);
    }

    if ($user === NULL || $user['roles'] !== 'ADMIN') {
        header('Location: index.php');
        exit;
    }

    $stmt = $conn->prepare(
        "SELECT id, nickname, username, roles FROM peipei_users ORDER BY id ASC"
    );
    $result = $stmt->execute();

    if (!$result) {
        die('Error' . $conn->error);
    }
    $result = $stmt->get_result();
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin area</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="warning">
        <strong>This is a website for practicing php. Please do not leave your normal password.</strong>
    </header>

    <main class="board">
        <section class="posts_container">
            <table border>
                <tr>
                    <th>id</th>
                    <th>role</th>
                    <th>nickname</th>
                    <th>username</th>
                    <th>Change role</th>
                </tr>
            <?php
                while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo escape($row['id']); ?></td>
                    <td><?php echo escape($row['roles']); ?></td>
                    <td><?php echo escape($row['nickname']); ?></td>
                    <td><?php echo escape($row['username']); ?></td>
                    <td>
                        <a href="handle_update_role.php?roles=ADMIN&id=<?php echo escape($row['id']);
                         ?>">ADMIN</a>
                        <a href="handle_update_role.php?roles=NORMAL&id=<?php echo escape($row['id']);
                         ?>">NORMAL USER</a>
                        <a href="handle_update_role.php?roles=BANNED&id=<?php echo escape($row['id']);
                         ?>">BANNED</a>
                    </td>
                </tr>
            <?php } ?>
            </table>
        </section>
    </main>
    <script>
    </script>
</body>
</html>