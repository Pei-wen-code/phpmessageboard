<?php
    session_start(); 
    require_once('conn.php'); 
    require_once('utils.php');

    $id = $_GET['id'];

    $username = NULL;
    $user = NULL;
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $user = getUserFromUsername($username);
    }

    $stmt = $conn->prepare(
        "SELECT * FROM peipei_comments WHERE id=?"
    );
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();

    if (!$result) {
        die('Error' . $conn->error);
    }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP message board</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="warning">
        <strong>This is a website for practicing php. Please do not leave your normal password.</strong>
    </header>

    <main class="board">
        <section class="form_container">
            <div class="form_head">
                <h1>Edit message</h1>
                    <?php
                        if (!empty($_GET['errCode'])) {
                            $code = $_GET['errCode'];
                            $msg = 'Erro';
                            if ($code === '1') {
                                $msg = 'Information is not completed.';
                            }
                            echo '<h2>Error message：' . $msg . '</h2>';
                        }
                    ?>
            </div>

            <div class="form_body">
                    <form method="POST" action="handle_update_comment.php">
                        <textarea class="form_body_content" rows="5" name="content"><?php 
                            echo escape($row['content']); ?></textarea>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
                        <input class="form_body_btn"type="submit" value="Submit" />
                    </form>
            </div>
        </section>
    </main>
</body>
</html>