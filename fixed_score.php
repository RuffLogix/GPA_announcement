<?php 
    include 'db.php';
    $cls = 'c_'.$_COOKIE["cls_opt"];
    $sbj_code = $_COOKIE["sbj_opt"];

    $sql = "SELECT * FROM $cls";

    $result = $db->query($sql);
    session_start();
?>

<?php 
    error_reporting(0); ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <!--Import Bootstrap-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

         <!--Import SweetAleart2-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.13.0/dist/sweetalert2.all.min.js"></script>
    </head>

    <body>
        <nav class="navbar navbar-light bg-light shadow">
            <div class="container-fluid">
                <a href="index.php">
                    <img src="img/logo.png" alt="Logo โรงเรียน" width="32" height="32" class="">
                </a>
                <?php 
                    echo 'ยินดีต้อนรับ คุณครู '.$_SESSION["teacher_name"];
                ?>

            </div>
        </nav>
        <div class="container" style="margin-top:2rem">
            
                
            <?php 
                if($_SESSION["role"]!=2){
                    ?>
                        <script>
                            const Toast = Swal.mixin({
                                timer: 1000,
                                timerProgressBar: true
                            })
            
                            Toast.fire({
                                icon: 'error',
                                title: 'กรุณาเข้าสู่ระบบอีกครั้ง'
                            })
                            setTimeout(()=>{window.location.href = "index.php"},100000);
                        </script>
                    <?php
                }
                echo '<p style="font-size:2.5rem;margin-top:0">'.'คะแนนวิชา '.$_COOKIE["sbj_opt"].' ห้อง '.$_COOKIE["cls_opt"].'</p>'  ;
                echo '<input type="button" value="กลับไปหน้าเลือกห้อง" style="margin-top:1rem;margin-bottom:1rem;" class="btn btn-success" onclick="document.location.href = `teacher_page.php`">'
            ?>
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post"> 
            <?php 
                while($row = $result->fetch_assoc()){
                    $cd_id = $row['เลขประจำตัว'];
                    if($row['เลขประจำตัว']!="max_student"){
                        $sql_name = "SELECT * FROM student_info WHERE เลขประจำตัว = $cd_id";
                        $result_ = $db->query($sql_name);
                        $row_ = $result_->fetch_assoc();
                        echo '<div class="row" style="margin-top:0.5rem;">';
                        echo '<div class="col-6">'.$row_["เลขที่"].' '.$row_["ชื่อ"]." ".$row_["สกุล"]."<br>".'</div>';
                        echo '<div class="col-6">'.'<input type="text" class="form-control" name=" '.$row['เลขประจำตัว'].'" placeholder="'."คะแนนเดิม : ".$row[$_COOKIE['sbj_opt']].'" required>'.'</div>';
                        //echo '<div class="col d-grid"><input type="reset" class="btn btn-danger" value="X" style="width:100%"></div>';
                        echo '</div>';
                    }else{
                        echo '<div class="row" style="margin-top:0.5rem;">';
                        echo '<div class="col-6">'.'<p>คะแนนเต็ม</p>'.'</div>';
                        echo '<div class="col-6">'.'<input type="text" class="form-control" placeholder="คะแนนเต็มของทั้งหมด" name="'.$row['เลขประจำตัว'].'" required>'.'</
                        div>';                        
                        echo '</div>';
                    }
                }
            ?>

            <div class="row" style="margin-left:0%"><div class="col d-grid">
                <input type="submit" class="col btn btn-danger" value="ส่งข้อมูล" style="margin-top:1.5rem;">
            </div></div>
            </form>
            <?php 
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $sql = "SELECT * FROM $cls";

                    $result = $db->query($sql);

                    while($row = $result->fetch_assoc()){
                        $score = $_POST[$row["เลขประจำตัว"]];
                        $lek = $row["เลขประจำตัว"];
                        $cmd = "UPDATE $cls SET $sbj_code = $score WHERE เลขประจำตัว = $lek";
                        $db->query($cmd);
                    }
                }
                $score = $_POST["max_student"];
                $cmd = "UPDATE $cls SET $sbj_code = $score WHERE เลขประจำตัว = 'max_student'";
                $db->query($cmd);
            ?>
        </div>
    </body>
</html>