<?php
    include('../connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="refresh" content="2" >
    <title>Document</title>
</head>

<?php
    $liqry = $con->prepare("SELECT `name` FROM `player` WHERE active = true ORDER BY id ASC LIMIT 1");
    $liqry->bind_result($nameOne);
    $liqry->execute();
    $liqry->store_result();

    $liqry2 = $con->prepare("SELECT `name` FROM `player` WHERE active = true ORDER BY id DESC LIMIT 1");
    $liqry2->bind_result($nameTwo);
    $liqry2->execute();
    $liqry2->store_result();

    $liqry3 = $con->prepare("SELECT `id`FROM `player` WHERE turn = true");
    $liqry3->bind_result($dbId);
    $liqry3->execute();
    $liqry3->store_result();
?>

<body>
    <div class="container">
        <div class="border">
            <div class="names">
                <div id="nameOne">
                    <h1><?php $liqry->fetch(); echo $nameOne; ?></h1>
                </div>
                <div id="nameTwo">
                    <h1><?php $liqry2->fetch(); echo $nameTwo; ?></h1>
                </div>
                <?php
                    $liqry3->fetch();
                    if($dbId == '1'){
                        echo "<div id='turnLeft'></div>";
                    } else{
                        echo "<div id='turnRight'></div>";
                    }
                ?>
            </div>
            <div class="game">
                <div class="grid">
                <?php
                    $liqry4 = $con->prepare("SELECT `color`, `move` FROM `player` WHERE turn = true LIMIT 1");
                    $liqry4->bind_result($color, $move);
                    $liqry4->execute();
                    $liqry4->store_result();
                    $liqry4->fetch();

                    for ($k = 0 ; $k < '7'; $k++){
                        if($k == $move){
                            echo '<div class="hidden"><div style="background-color:' . $color . ';" class="seen"></div></div>';
                        } elseif($k <= '7'){
                            echo '<div class="hidden"></div>'; 
                        }
                        
                    }
                    
                    $liqry5 = $con->prepare("SELECT `color` FROM `player` WHERE id = 1 LIMIT 1");
                    $liqry5->bind_result($colorOne);
                    $liqry5->execute();
                    $liqry5->store_result();

                    $liqry6 = $con->prepare("SELECT `color` FROM `player` WHERE id = 2 LIMIT 1");
                    $liqry6->bind_result($colorTwo);
                    $liqry6->execute();
                    $liqry6->store_result();

                    for ($i = 0 ; $i < '49'; $i++){
                        if($i == 48 || $i == 46 || $i == 45){
                            $liqry5->fetch();
                            echo '<div style="background-color:' . $colorOne . ';" class="filled"></div>';
                        } elseif($i == 47 || $i == 43 || $i == 44){
                            $liqry6->fetch();
                            echo '<div style="background-color:' . $colorTwo . ';" class="filled"></div>';
                        }else{
                            echo '<div class="hole"></div>'; 
                        }
                        
                    }
                ?> 
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>