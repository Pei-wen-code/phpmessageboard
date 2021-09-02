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

    $page = 1;
    if (!empty($_GET['page'])) {
        $page = intval($_GET['page']);
    }
    $items_per_page = 3;
    $offset = ($page - 1) * $items_per_page;

    $stmt = $conn->prepare(
        'SELECT '.
            'C.id as id, C.content as content, '.
            'C.created_at as created_at, U.nickname as nickname, U.username as username '.
        'FROM peipei_comments as C '.
        'LEFT JOIN peipei_users as U ON C.username = U.username '.
        'WHERE C.is_deleted IS NULL '.
        'ORDER BY C.id DESC '.
        'LIMIT ? OFFSET ? '
    );
    $stmt->bind_param('ii', $items_per_page, $offset);
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
                <?php if (!$username) { ?>
                    <a class="member_btn" href="register.php">Register</a>
                    <a class="member_btn" href="login.php">Login</a>
                <?php } else { ?>
                    <a class="member_btn" href="logout.php">Logout</a>
                    <span class="member_btn update_nickname">Edit nickname</span>
                    <?php if ($user && $user["roles"] === "ADMIN") { ?>
                        <a class="member_btn" href="admin_index.php">Admin area</a>
                    <?php } ?>
                    <form class="hide board_nickname-form form_body" method="POST" action="update_user.php">
                        <span>New nickname：</span>
                        <input class="form_body_content" type="text" name="nickname" /><br>
                        <input class="member_btn" type="submit" />
                    </form>
                    <h3>Hi there！<?php echo $user['nickname']; ?></h3>
                <?php } ?>

                <h1>What do you want to say...?</h1>
                    <?php
                        if (!empty($_GET['errCode'])) {
                            $code = $_GET['errCode'];
                            $msg = 'Error';
                            if ($code === '1') {
                                $msg = 'Please fill in all fields';
                            }
                            echo '<h2>Error message：' . $msg . '</h2>';
                        }
                    ?>
            </div>

            <div class="form_body">
                <form method="POST" action="handle_add_post.php">
                    <textarea class="form_body_content" rows="5" name="content" placeholder="Leave your message here..."></textarea>
                    <?php if ($username && !hasPermission($user, "create", NULL)) { ?>
                        <h3>You are unauthrised. Please contact the admin.</h3>
                    <?php } else if ($username) { ?>
                        <input class="form_body_btn"type="submit" value="Submit" />
                    <?php } else {?>
                        <h3>Please login to leave your message</h3>
                    <?php }?>
                </form>
                <div class="form_hr"></div>
            </div>
        </section>

        <section class="posts_container">
            <?php
                while ($row = $result->fetch_assoc()) {
            ?>
                <div class="posts">
                    <div class="posts_avatar"></div>
                    <div class="posts_info">
                        <div class="info_upper">
                            <span class="info_upper_nickname">
                                <?php echo escape($row['nickname']); ?>
                                (@<?php echo escape($row['username']); ?>)
                            </span>
                            <span class="info_upper_time"><?php echo escape($row['created_at']); ?></span>
                            <?php if ($username) { ?>
                                <?php if (hasPermission($user, "update", $row)) { ?>
                                    <a href="update_comment.php?id=<?php echo $row['id']; ?>">Edit</a>
                                    <a href="delete_comment.php?id=<?php echo $row['id']; ?>">Delete</a>
                                <? } ?>
                            <?php }?>
                        </div>
                        <p class="info_lower"><?php echo escape($row['content']); ?></p>
                    </div>
                </div>
            <?php } ?>
        </section>
        
        <section>
            <div class="dividen"></div>
            <?php
                $stmt = $conn->prepare(
                    'SELECT count(id) as count FROM peipei_comments WHERE is_deleted IS NULL'
                );
                $result = $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $count = $row['count'];
                $total_page = ceil($count / $items_per_page);
            ?>
            <div class="page_info">
                <span>Total of messages are <?php echo $count; ?>，this is page：</span>
                <span><?php echo $page; ?> / <?php echo $total_page; ?></span>
            </div>
            <div class="pagenator">
                <?php if ($page != 1) { ?>
                    <a href="index.php?page=1">First page</a>
                    <a href="index.php?page=<?php echo $page - 1; ?>">Previous</a>
                <?php } ?>
                <?php if ($page != $total_page) { ?>
                    <a href="index.php?page=<?php echo $page + 1; ?>">Next</a>
                    <a href="index.php?page=<?php echo $total_page; ?>">Last page</a>
                <?php } ?>
            </div>
        </section>
    </main>
    <script>
    let btn = document.querySelector('.update_nickname')
    btn.addEventListener('click', function() {
        let form = document.querySelector('.board_nickname-form')
        form.classList.toggle('hide')
    })
    </script>
</body>
</html>
