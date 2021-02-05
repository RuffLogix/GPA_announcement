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
    
    <script>
        let i=1;
        $(document).ready(function (){
            document.cookie = "max_len="+i;
            $("#add_btn").click(function (){
                document.cookie = "max_len="+i;
                $("#subject-form").append('<div class="row d-grid" id="row-box-'+i+'" style="margin-top:0.3rem"><div class="d-flex" style="padding:0"><input type="text" name="'+i+'" id="inp-box-'+i+'" class="form-control" placeholder="รหัสวิชา (Subject Code)" style="margin-right:0.2rem" required><input type="text" name="c-'+i+'" class="form-control" style="margin-right:0.2rem" placeholder="หน่วยกิต (Credit)" id="credit-'+i+'" required><button class="btn btn-danger" id="del-btn-'+i+'" type="button" onclick="del_box('+i+')">ลบ</button></div></div>');
                i++;
            });
        });

        function del_box(elm_id){
            let btn = document.getElementById("del-btn-"+elm_id);
            let box = document.getElementById("inp-box-"+elm_id);
            let pbb = document.getElementById("row-box-"+elm_id);
            let crd = document.getElementById("credit"+elm_id);
            
            pbb.parentNode.removeChild(pbb);
            crd.parentNode.removeChild(crd);
            btn.parentNode.removeChild(btn);
            box.parentNode.removeChild(box);
        }
    </script>

</head>
<body>
    <div class="container d-gird" style="margin-top:8%;width:30rem">

        <div class="title">
            <center>
                <h2>สร้างฐานข้อมูล</h2>
            </center>
        </div>

        <div class="row">
            <button class="btn btn-success" id="add_btn">เพิ่มวิชา</button>
        </div>

        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">

            <div class="info d-flex row" style="margin-top:0.3rem">
                <input type="text" name="c_name" class="form-control" stlye="padding:0" placeholder="ห้อง (เช่น 101)" required>
            </div>

            <div class="" id="subject-form">
                <div class="row d-grid" id="row-box-0" style="margin-top:0.3rem">
                    <div class="d-flex" style="padding:0">
                        <input type="text" name="0" id="inp-box-0" class="form-control" placeholder="รหัสวิชา (Subject Code)" style="margin-right:0.2rem" required>
                        <input type="text" name="c-0" class="form-control" style="margin-right:0.2rem" placeholder="หน่วยกิต (Credit)" id="credit-0" required>
                        <button class="btn btn-danger" id="del-btn-0" type="button" onclick="del_box(0)">ลบ</button>
                    </div>
                </div>
            </div>

            <div class="d-grid row" style="padding:0;margin-top:0.5rem">
                <button type="submit" class="btn btn-danger" name="" id="">สร้างฐานข้อมูล (Create Database)</button>
            </div>

        </form>

        <?php 
            include 'db.php';

            if($_SERVER["REQUEST_METHOD"]=="POST"){

                //Create table
                $max_len = $_COOKIE["max_len"];
                $sql_command = "CREATE TABLE "."c_".$_POST['c_name']."( เลขประจำตัว TEXT";
                $subject = "";

                $mx_subject = 0;
                for($i=0 ; $i<=$max_len ; $i++){
                    if(isset($_POST[$i])){
                        $mx_subject++;
                        $sql_command = $sql_command." ,".$_POST[$i]." TEXT";
                        #$_POST['c-'.$i];
                    }
                }
                $sql_command = $sql_command.");";

                //echo $sql_command."<br>"; //Debugจ้าา
                $db->query($sql_command);

                //เพิ่มสมาชิกในตาราง
                $sql_command = "SELECT เลขประจำตัว from student_info WHERE ห้อง = ".$_POST["c_name"];
                $result = $db->query($sql_command);
                
                //*เพิ่มข้อมูลของแต่ละคนแบบ ง่อยๆ :)))))
                while($rows = mysqli_fetch_assoc($result)){
                    $insert_data = "INSERT INTO c_".$_POST["c_name"]." VALUES (".$rows["เลขประจำตัว"];
                    for($i=0 ; $i<$mx_subject ; $i++){
                        $insert_data = $insert_data.", 0";
                    }
                    $insert_data = $insert_data.")";   
                    $db->query($insert_data);
                }

                //*Add ตัวเก็บคะแนนเต็ม
                $insert_data = "INSERT INTO c_".$_POST["c_name"].' VALUES ( "max_student"';
                for($i=0 ; $i<$mx_subject ; $i++){
                    $insert_data = $insert_data.", 0";
                }
                $insert_data = $insert_data.")";   
                $db->query($insert_data);

                /*
                Debug จ้าาาาา
                    echo $insert_data."<br>";
                    echo $sql_command;
                */
                
            }


        ?>
    </div>
</body>
</html>