<?php
    include('../../connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="2" >
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <title>Document</title>
</head>

<style>
    #droppable { width: 100px; 
        height: 100px; 
        padding: 0.5em; 
        float: left; 
        margin: 10px; 
        text-align: center;
    }

    .ui-widget-content {
        border: 2px solid black;
        background-color:
        <?php
            $uid = $_GET['uid'];
            $liqry4 = $con->prepare("SELECT `color` FROM `player` WHERE id = ? LIMIT 1");
            $liqry4->bind_param('i', $uid);
            $liqry4->bind_result($color);
            $liqry4->execute();
            $liqry4->store_result();
            $liqry4->fetch();
            echo $color;
        ?>
        ;
    }
</style>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $( function() {
    $( "#seen" ).draggable();
    $( "#droppable" ).droppable({
      drop: function( event, ui ) {
        $( this )
            .addClass( "ui-state-highlight" )
            .find( "p" )
            .html( "Waiting!" );
            location.replace("index.php?destruction=true&uid=<?php $uid = $_GET['uid']; echo $uid; ?>")
        }
    });
});
</script>

<?php 
    include('turn.php');

    $liqry = $con->prepare("SELECT `name` FROM `player` WHERE active = true ORDER BY id ASC LIMIT 1");
    $liqry->bind_result($nameOne);
    $liqry->execute();
    $liqry->store_result();

    $liqry2 = $con->prepare("SELECT `name` FROM `player` WHERE active = true ORDER BY id DESC LIMIT 1");
    $liqry2->bind_result($nameTwo);
    $liqry2->execute();
    $liqry2->store_result();

    $liqry3 = $con->prepare("SELECT `turn` FROM `player` WHERE active = true AND id = ? ORDER BY id LIMIT 1");
    $liqry3->bind_param('s', $uid);
    $liqry3->bind_result($turn);
    $liqry3->execute();
    $liqry3->store_result();
?>

<body>
    <div class="container">
        <div class="border">
            <div class="nameVsName">
                <div id="nameOne">
                    <h1>
                        <?php $liqry->fetch(); echo $nameOne; ?>
                    </h1>
                </div>
                <div class="vs"><h2><i>VS</i></h2></div>
                <div id="nameTwo">
                    <h1>
                        <?php $liqry2->fetch(); echo $nameTwo; ?>
                    </h1>
                </div>
            </div>
            <div id="turn">
                <?php
                    $liqry3->fetch();
                    if($turn == true){
                        echo "Your turn";
                    } else{
                        echo "Opponents turn";
                    }
                ?>
            </div>
            <div class="control">
                <a id="left" href='index.php?uid=<?php echo $uid; ?>&left=true'>
                    <div class="leftArrow"></div>
                </a>
                <a id="right" href='index.php?uid=<?php echo $uid; ?>&right=true'>
                    <div class="rightArrow"></div>
                </a>
                <div id="drop">
                    <a href='index.php?uid=<?php echo $uid; ?>&drop=true'>DROP IT</a>
                </div>
            </div>
        </div>
        <div id="seen" class="ui-widget-content">
            DRAG
        </div>
        <div id="droppable" class="ui-widget-header">
            <p>SELF DESTRUCT</p>
        </div>
    </div>
</body>

</html>