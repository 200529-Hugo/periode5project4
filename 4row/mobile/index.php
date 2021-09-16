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
    <title>Document</title>
</head>

<?php 
    if (isset($_POST['submit']) && $_POST['submit'] != '') {
        $name = $con->real_escape_string($_POST['name']);
        $color = $con->real_escape_string($_POST['color']);
        $liqry = $con->prepare("UPDATE player SET color=? WHERE name = ?");
        if($liqry === false) {
           echo mysqli_error($con);
        } else{
            $liqry->bind_param('ss',$color,$name);
            if($liqry->execute()){
                $liqry = $con->prepare("SELECT id, name FROM player WHERE name = ? LIMIT 1;");
                if($liqry === false) {
                    trigger_error(mysqli_error($con));
                } else{
                    $liqry->bind_param('s',$name);
                    $liqry->bind_result($uid,$dbname);
                    if($liqry->execute()){
                        $liqry->store_result();
                        $liqry->fetch();
                        if($name == $dbname){
                            $_SESSION['id'] = $uid;
                            $_SESSION['name'] = $name;
                            header('location:control/index.php?uid=' . $uid);
                        }
                    } 
                    $liqry->close();
                }
            }
        }
        
    }
?>

<body>
    <div class="container">
        <div class="border">
            <header>
                <h2>CONNECT <i>4</i></h2>
            </header>
            <form class="content" action="index.php" method="POST">
                <input type="text" name="name">
                <br>
                <input type="color" id="color" name="color">
                <div id="chip"></div>
                <br>
                <input type="submit" value="START" class="button" name="submit">
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>