<?php
    require_once("util.inc");
    db_init();
    if (strlen($HTTP_POST_VARS["old"])) {
        $query = sprintf(
            "select * from user where email_addr='%s'",
            $HTTP_POST_VARS["existing_email"]
        );
        $result = mysql_query($query);
        $user = mysql_fetch_object($result);
        mysql_free_result($result);
        if (!$user or ($user->web_password != $HTTP_POST_VARS["existing_password"])) {
            echo "We have no account with that name and password.";
        } else {
            setcookie("auth", $user->authenticator, time()+100000000);
            echo "Logged in.";
        }
    } else if (strlen($HTTP_POST_VARS["new"])) {
        $query = sprintf(
            "select * from user where email_addr='%s'",
            $HTTP_POST_VARS["new_email_addr"]
        );
        $result = mysql_query($query);
        $user = mysql_fetch_object($result);
        mysql_free_result($result);
        if ($user) {
            echo "There's already an account with that email address.";
        } else {
            if ($HTTP_POST_VARS["new_password"] != $HTTP_POST_VARS["new_password2"]) {
                echo "You've typed two different passwords.";
            } else {
                $authenticator = random_string();
                $email_addr = $HTTP_POST_VARS["new_email_addr"];
                $query = sprintf(
                    "insert into user values(0, %d, '%s', '%s', '%s', '%s')",
                    time(),
                    $email_addr,
                    $HTTP_POST_VARS["new_name"],
                    $HTTP_POST_VARS["new_password"],
                    $authenticator
                );
                $result = mysql_query($query);
                if ($result) {
                    setcookie("auth", $authenticator);
                    echo "Account created.  You are being mailed a key that you'll need to run the client.\n";
                    mail($email_addr, "SETI@home key", "Your SETI@home key is " . $authenticator);
                } else {
                    echo "Couldn't create account - please try later.\n";
                }
            }
        }
    }
    page_tail();
?>
