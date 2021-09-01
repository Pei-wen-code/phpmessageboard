<?php
    require_once('conn.php');

    function generateToken() {
        $s = '';
        for($i = 1; $i<=16; $i++) {
            $s .= chr(rand(65, 90));
        }
        return $s;
    }

    function getUserFromUsername($username) {
        global $conn;

        $sql = sprintf("SELECT * From peipei_users WHERE username = '%s'", $username);
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row;
    }

    function escape($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }

    function hasPermission($user, $action, $comment) {
        if ($user["roles"] === "ADMIN") {
            return true;
        }

        if ($user["roles"] === "NORMAL") {
            if ($action === "create") return true;
            return $comment["username"] === $user["username"];
        }

        if ($user["roles"] === "BANNED") {
            return $action !== "create";
        }
    }

    function isAdmin($user) {
        return $user["roles"] === "ADMIN";
    }
?>