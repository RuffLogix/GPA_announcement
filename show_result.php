<?php 
    session_start();
    include 'db.php';

    $student_id = $_SESSION['id_name'];
    $sql = "SELECT * FROM student_info WHERE เลขประจำตัว = '$student_id'";
    $result =  $db->query($sql);
    $student_data = $result->fetch_assoc();
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
        $(document).ready(function (){
            let d = new Date();
            let m = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤษจิกายน", "ธันวาคม"];
            $("#title_").text("ภาคเรียนที่ 2 ปีการศึกษา 2563 ข้อมูล วันที่ "+d.getDay()+" "+m[d.getMonth()]+ " "+(d.getFullYear()+543));
        });
    </script>
</head>
<body>
    <center>
    <div class="container" style="margin-top:3%">
        <div class="row">
            <div class="col"><img src="img/logo.png" width="110rem" style="margin-bottom:1rem"></div>
        </div>
        <div class="row">
            <div class="col">
                <p style="font-size:1.3rem;margin:0%">ใบแจ้งผลคะแนนระหว่างภาค โรงเรียนเบญจมราชูทิศ</p><br>
            </div>
        </div>
        <div class="row">
            <div class="col"><p style="font-size:1.3rem;margin:0%" id="title_"></p><br></div>
        </div>
        <div class="row">
            <div class="col">
                <?php 
                    if($_SESSION['id_name']!="Undefined"){
                        echo '<p style="font-size:1.3rem;margin:0%">';
                        echo 'ชื่อ-สกุล นักเรียน <b>'.$student_data["เพศ"].$student_data["ชื่อ"].' '.$student_data["สกุล"];
                        echo '</b> ห้อง <b>'.$student_data["ห้อง"].'</b> เลขประจำตัว <b>'.$student_data["เลขประจำตัว"].'</b>';
                        echo '</p>';
                    }else{
                        echo '<p style="font-size:5rem">กรุณาเข้าสู่ระบบอีกครั้ง</p>';
                    }
                ?>
            </div>
        </div>

        <div class="report-data" style="margin:0;width:100%;margin-left:22%;margin-top:1rem;text-align: center;">
            <div class="row">
                <div class="col-1 border"><b>วิชาที่</b></div>
                <div class="col-3 border"><b>รหัสวิชา</b></div>    
                <div class="col-1 border"><b>เต็ม</b></div>    
                <div class="col-1 border"><b>ได้</b></div>    
                <div class="col-1 border"><b>ร้อยละ</b></div>      
            </div>
            <?php 
                if($_COOKIE["role"]!=1){
                    //echo $_COOKIE["role"];
                    ?>
                        <script>
                            const Toast = Swal.mixin({
                                timer: 3000,
                                timerProgressBar: true
                            })
                
                            Toast.fire({
                                icon: 'error',
                                title: 'กรุณาเข้าสู่ระบบอีกครั้ง'
                            })
                            setTimeout(()=>{window.location.href = "index.php"},3000);
                        </script>
                    <?php
                }
                if($_SESSION['id_name']!="Undefined"){
                    $class_student = 'c_'.$student_data["ห้อง"];
                    $sql_student_info = "SELECT * FROM $class_student WHERE เลขประจำตัว = '$student_id'";
                    $result_student = ($db->query($sql_student_info))->fetch_assoc();
                    $sql_student_max = "SELECT * FROM $class_student WHERE เลขประจำตัว = 'max_student'";
                    $result_student_max = ($db->query($sql_student_max))->fetch_assoc();

                    $q_get_table = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$class_student' ORDER BY ORDINAL_POSITION";
                    $result_q_get_table = $db->query($q_get_table);

                    $cnt_row = 1;
                    while($row = $result_q_get_table->fetch_assoc()){
                        if($row["COLUMN_NAME"] != 'เลขประจำตัว' ){
                            $sbj = $row["COLUMN_NAME"];
                            echo '<div class="row">';
                            echo '<div class="col-1 border">'.$cnt_row.'</div>';
                            echo '<div class="col-3 border">'.$row["COLUMN_NAME"].'</div>';
                            echo '<div class="col-1 border">'.$result_student_max[$sbj].'</div>';
                            echo '<div class="col-1 border">'.$result_student[$sbj].'</div>';
                            $pct = '';
                            if((int)$result_student_max[$sbj]!=0){
                                $pct = round((int)$result_student[$sbj]/(int)$result_student_max[$sbj]*100,2);
                            }else{
                                $pct = 'Nan';
                            }
                            echo '<div class="col-1 border">'.$pct.'</div>'; 
                            echo '</div>';
                            $cnt_row++;
                        }
                    }
                }
            ?>
        </div>
    </div>
    </center>
</body>
</html>