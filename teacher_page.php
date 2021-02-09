<?php 
    session_start(); 
    include 'db.php';

    $tch_name = $_SESSION["teacher_name"];
    $sql = "SELECT * FROM teacher_info WHERE ชื่อ='$tch_name'";

    $result = $db->query($sql);
    
     error_reporting(0); ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!--Import Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
   
    <!--Import JQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <!--Import SweetAleart2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.13.0/dist/sweetalert2.all.min.js"></script>

    <script>
        function q(num){
            if(num==null)return;
            let num_opt = document.getElementById(num).id;
            let sbj_opt = document.getElementById(num).name;
            document.cookie = "sbj_opt="+sbj_opt;
            document.cookie = "cls_opt="+num_opt;
            <?php $_SESSION["role"]=2; ?>
            const Toast = Swal.mixin({
                timer: 1000,
                timerProgressBar: true
            })

            Toast.fire({
                icon: 'success',
                title: 'กำลังเข้าสู่หน้าถัดไป'
            })
            setTimeout(() => {
                document.location.href = "fixed_score.php";
            }, 1000);
            //alert(num_opt+sbj_opt);
        }
    </script>
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
    <div class="container">
        <?php 
            if($_SESSION["role"]!=2){
                echo $_SESSION["role"];
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
                        setTimeout(()=>{window.location.href = "index.php"},1000);
                    </script>
                <?php
            }
            while($row = $result->fetch_assoc()){
                $cl = (string)$row["ห้องที่สอน"];
                echo '<p style="margin:0rem;font-size:1.5rem">'.$row["รหัสวิชา"].'</p>';
                echo '<div class="row">';
                $cls_str = "";
                for($i=0 ; $i<strlen($cl) ; $i++){
                    if($cl[$i]==',' or $i==strlen($cl)-1){
                        if($i==strlen($cl)-1)$cls_str=$cls_str.$cl[$i];
                        echo '<div class="d-grid"><input type="button" style="padding:1.5rem;margin:0;margin-top:0.3rem"value=ห้อง'.$cls_str.' class="btn btn-success" onclick="q('.$cls_str.')" name="'.$row['รหัสวิชา'].'" id="'.$cls_str.'" style="margin-right:1rem"></div>';
                        $cls_str="";
                    }else{
                        $cls_str=$cls_str.$cl[$i];
                    }
                }
                echo '</div>';
            }
        ?>
    </div>
</body>
</html>