<?php 
    require_once('conn.php'); 
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="warning">
        <strong>This is a website for practicing php. Please do not leave your normal password.</strong>
    </header>

    <main class="board">
        <section class="form_container">
            <div class="form_head">
                <a class="member_btn" href="index.php">Back</a>
                <a class="member_btn" href="login.php">Login</a>
                <h1>Register</h1>
                    <?php
                        if (!empty($_GET['errCode'])) {
                            $code = $_GET['errCode'];
                            $msg = 'Erro';
                            if ($code === '1') {
                                $msg = 'Information is not completed.';
                            } else if ($code === '2') {
                                $msg = 'The account has been registered.';
                            }
                            echo '<h2>Error message：' . $msg . '</h2>';
                        }
                    ?>
            </div>
            <div class="form_body">
                <form method="POST" action="handle_register.php">
                    <span>Nickname</span>
                    <input class="form_body_nickname" type="text" name="nickname" />
                    <span>Account name</span>
                    <input class="form_body_username" type="text" name="username" />
                    <span>Password</span>
                    <input class="form_body_password" type="password" name="password" />
                    <input class="form_body_btn"type="submit" value="Submit" />
                </form>
            </div>
        </section>
    </main>
</body>
</html>