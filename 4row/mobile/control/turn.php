<?php
    $uid = $_GET['uid'];
    echo $uid;

    function left() {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "connect4";

        $con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        $uid = $_GET['uid'];
        $liqry = $con->prepare("SELECT `move` FROM `player` WHERE active = true AND id = ?");
        $liqry->bind_param('s',$uid);
        $liqry->bind_result($dbMove);
        $liqry->execute();
        $liqry->store_result();
        $liqry->fetch();

        if($dbMove <= '6'){
            if($dbMove == '0'){
                ++$dbMove;
            }else{
                --$dbMove;
                $liqry2 = $con->prepare("UPDATE player SET move = ? WHERE id = ?");
                $liqry2->bind_param('ss',$dbMove,$uid);
                if($liqry2->execute()){
                    header( "refresh:1;url=index.php?uid=" . $uid);
                }
            }
        }
    }

    function right() {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "connect4";

        $con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        $uid = $_GET['uid'];
        $liqry = $con->prepare("SELECT `move` FROM `player` WHERE active = true AND id = ?");
        $liqry->bind_param('s',$uid);
        $liqry->bind_result($dbMove);
        $liqry->execute();
        $liqry->store_result();
        $liqry->fetch();

        if($dbMove >= '0'){
            if($dbMove == '6'){
                --$dbMove;
            }else{
                ++$dbMove;
                $liqry2 = $con->prepare("UPDATE player SET move = ? WHERE id = ?");
                $liqry2->bind_param('ss',$dbMove,$uid);
                if($liqry2->execute()){
                    header( "refresh:1;url=index.php?uid=" . $uid);
                }
            }
        }
    }

    function drop() {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "connect4";

        $con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        
        $uid = $_GET['uid'];
        $liqry = $con->prepare("SELECT `move` FROM `player` WHERE active = true AND id = ?");
        $liqry->bind_param('s',$uid);
        $liqry->bind_result($dbMove);
        $liqry->execute();
        $liqry->store_result();
        $liqry->fetch();

        $liqry2 = $con->prepare("UPDATE player SET move = ? WHERE id = ?");
        if($liqry2 === false) {
           echo mysqli_error($con);
        } else{
            $liqry2->bind_param('ss',$move,$uid);
            if($liqry2->execute()){
                echo $move;
                header( "refresh:1;url=index.php?uid=" . $uid);
                turn();
            }
        }
    }

    function turn(){
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "connect4";

        $con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        $uid = $_GET['uid'];
        $off = false;
        $on = true;

        $liqry = $con->prepare("SELECT `id` FROM `player` WHERE active = true AND id = ?");
        $liqry->bind_param('s',$uid);
        $liqry->bind_result($dbId);
        $liqry->execute();
        $liqry->store_result();
        $liqry->fetch();
        if($dbId == $uid){
            $liqry2 = $con->prepare("SELECT `turn` FROM `player` WHERE id = ? ORDER BY id LIMIT 1");
            $liqry2->bind_param('s',$dbId);
            $liqry2->bind_result($dbTurn);
            $liqry2->execute();
            $liqry2->store_result();
            $liqry2->fetch();
            if($dbTurn == true){
                $liqry3 = $con->prepare("UPDATE player SET turn = ? WHERE id = ?");
                $liqry3->bind_param('ss',$off,$dbId);
                if($liqry3->execute()){
                    $liqry4 = $con->prepare("UPDATE player SET turn = ? WHERE NOT id = ?");
                    $liqry4->bind_param('ss',$on,$dbId);
                    $liqry4->execute();
                }
            }
        }
    }

    function destruct(){
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "connect4";

        $con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        $uid = $_GET['uid'];
        $yes = true;

        $liqry = $con->prepare("UPDATE player SET destruct = ? WHERE id = ?");
        $liqry->bind_param('ss',$yes,$uid);
        $liqry->execute();
    }

    function destroy(){
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "connect4";

        $con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        $liqry = $con->prepare("SELECT `destruct` FROM `player` WHERE id = 1");
        $liqry->bind_result($destructOne);
        $liqry->execute();
        $liqry->store_result();
        $liqry->fetch();
        if($destructOne == 1){
            $liqry2 = $con->prepare("SELECT `destruct` FROM `player` WHERE id = 2");
            $liqry2->bind_result($destructTwo);
            $liqry2->execute();
            $liqry2->store_result();
            $liqry2->fetch();
            if($destructTwo == 1 && $destructOne == 1){
                $liqry = $con->prepare("UPDATE player SET destruct = 1");
                $liqry->execute();
                header('location: ../index.php');
            }
        }
    }

    if (isset($_GET['left'])) {
        left();
    }

    if (isset($_GET['right'])) {
        right();
    }

    if (isset($_GET['drop'])) {
        drop();
    }

    if(isset($_GET['destruction'])){
        destruct();
        destroy();
    }
?>