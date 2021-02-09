<?php 
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
   
    <link rel="stylesheet" href="css/add_teacher_info.css">

    <!--Import SweetAleart2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.13.0/dist/sweetalert2.all.min.js"></script>

    <script src="js/del_btn.js"></script>

    <script>
        let i=0;
        $(document).ready(function (){
            $('#add_btn').click(function (){
                i++;
                document.cookie = "btn_value="+i;
                $('.add_subject').append('<div class="row" style="margin-top:0.5rem" id="row-box-'+i+'"><div class="col"><input type="text" placeholder="รหัสวิชา (ว11101)" class="form-control" id="inp-box-'+i+'" required name="subject-code'+i+'"></div><div class="col"><input type="text" placeholder="ห้องที่สอน (เช่น 1 ถ้ามีหลายห้องให้ใส่ ,)" class="form-control" id="credit'+i+'" required name="class-'+i+'"></div><div class="col d-grid"><input type="button" value="ลบ" class="btn btn-danger" onclick="del_box('+i+')" id="del-btn-'+i+'"></div></div>');
            });
        });
    </script>

    
</head>
<body>
    <div class="container" style="margin-top:7%;width:70%">
        <div class="title_add_teacher_info">เพิ่มรายชื่อครู และ รายวิชาที่สอน</div>
        <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
            <div class="row">
                <div class="col"><input type="text" placeholder="ชื่อครู (Teacher Name)" class="form-control" required name="teacher_name"></div>
                <div class="col d-grid"><input type="button" id="add_btn" value="เพิ่มวิชา" class="btn btn-success"></div>
            </div>
            <div class="add_subject">
                <!--JQuery's work not me ;-;-->
            </div>

            <div class="row submit-button">
                <div class="col d-grid"><input type="submit" class="btn btn-danger" <?php if($_SESSION["role"]!=3)echo 'disabled'?>></div>
            </div>
        </form>

        <?php 
            if($_SESSION["role"]!=3){
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
            include 'db.php';
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                for($i=1 ; $i<=$_COOKIE["btn_value"] ; $i++){
                    if(isset($_POST["teacher_name"]) and isset($_POST["subject-code".$i]) and isset($_POST["class-".$i])){
                        $t_name = $_POST["teacher_name"];
                        $s_code = $_POST["subject-code".$i];
                        $c_ = $_POST["class-".$i];
                        $sql_query = "INSERT INTO teacher_info VALUES ('$t_name','$s_code','$c_')";

                        $db->query($sql_query);
                    }
                }
            }
        ?>
    </div>
</body>
</html>