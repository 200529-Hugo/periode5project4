<?php
    $liqry4 = $con->prepare("SELECT `color`, `move` FROM `player` WHERE turn = true LIMIT 1");
    $liqry4->bind_result($color, $move);
    $liqry4->execute();
?>