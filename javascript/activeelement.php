<?php
declare(strict_types = 1);

header('Content-Type: text/html');

if (array_key_exists('PATH_INFO', $_SERVER) === false) {
    readfile("activeelement.html");
    exit;
} else {
    $requestedElement = $_SERVER['PATH_INFO'];
}


if (array_key_exists('attempt', $_GET) === false) {
    $attempt = 0;
} else {
    $attempt = $_GET['attempt'];
}

/**
 * Created by PhpStorm.
 * User: Rik Meijer
 * Date: 13-6-2016
 * Time: 9:45
 */
?>
<!-- meta http-equiv="refresh" content="2; url=activeelement.php?attempt=<?=$attempt+1;?>" -->
<style>
    strong {
        color: #FEF;
    }
    body {
        background-color: #aaa;
    }
</style>
<script>
    alert(window.top.document.title);
</script>
#<?=$attempt;?> Hello <strong>on</strong> World!