<?php 
    session_start();

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

    <!--Import SweetAleart2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.13.0/dist/sweetalert2.all.min.js"></script>

    <style>
        a{
            text-decoration: none;
        }
    </style>

    <?php   
        include 'db.php';
        if(!$db->error){
            echo '.';
        ?>
            <script>
            const db_status = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            db_status.fire({
                icon: 'success',
                title: 'เชื่อมต่อฐานข้อมูลสำเร็จ'
            })
            </script>
        <?php 
        }else{
            echo '.';
        ?>
            <script>
            const db_status = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            db_status.fire({
                icon: 'error',
                title: 'เชื่อมต่อฐานข้อมูลล้มเหลว'
            })
            </script>
            <?php 
        }
    ?>
</head>
<body>
    <div class="container" style="margin-top:auto;margin-top:8%">
    <div class="row">
        <div class="col">
            <center>
                <div style="border-radius:1rem;width:28rem;box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);padding-bottom:1rem">

                    <img src="img/logo.png" alt="Logo โรงเรียน" width="125rem" style="margin-top:1rem">

                    <h4>เข้าสู่ระบบ</h4>
                    <h4>ระบบรายงานผลการเรียนออนไลน์</h4>
                    <h4>Online Grade Announcement System</h4>

                    <form action="<?php $_SERVER["PHP_SELF"]?>" class="d-grid" style="width:26rem;" method="post">

                        <div class="input-group" style="margin-top:0.3rem">
                            <div class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                </svg>
                            </div>
                            <input type="text" name="username" class="form-control" placeholder="ชื่อผู้ใช้ (Username)" require>
                        </div>

                        <div class="input-group" style="margin-top:0.3rem">
                            <div class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16">
                                    <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน (Password)" require>
                        </div>

                        <input type="submit" name="" id="" class="btn btn-danger" value="เข้าสู่ระบบ (Login)" style="margin-top:0.7rem">
                    </form>
                </div>
            <center>
        </div>
    </div>
    </div>

    <?php
        
        include 'db.php';
        if(isset($_POST['username']) and isset($_POST['password']) and $_SERVER["REQUEST_METHOD"]=="POST"){

            $user = $_POST['username'];
            $sql = "SELECT * FROM student_info WHERE เลขประจำตัว='$user'"; //ค้นหา เลขประจำตัว ที่เหมือนกับ ที่รับค่าเข้ามา;
            $result = $db->query($sql);

            if($_POST['username']=="root" and $_POST['password']=="12345"){
                $_SESSION["role"] = 3;
                ?>
                <script>
                    const Toast = Swal.mixin({
                        timer: 1000,
                        timerProgressBar: true
                    })

                    Toast.fire({
                        icon: 'error',
                        title: 'ชื่อผู้ใช้/รหัสผ่าน ไม่ถูกต้อง'
                    })

                    setTimeout(()=>{window.location.href = "create_table.php"},1000);
                </script>
                <?php
            }

            if($result->num_rows==1){
                $row = mysqli_fetch_assoc($result); //ให้ row เก็บข้อมูลของทั้งแถว
                $chk_password = strval($row["ห้อง"]).strval($row["เลขที่"]); //ตัวแปรเช็ค password

                if($chk_password != $_POST['password']){
                    ?>
                        <script>
                            const Toast = Swal.mixin({
                                timer: 1000,
                                timerProgressBar: true
                            })

                            Toast.fire({
                                icon: 'error',
                                title: 'ชื่อผู้ใช้/รหัสผ่าน ไม่ถูกต้อง'
                            })

                            setTimeout(()=>{window.location.href = "index.php"},1000);
                        </script>
                    <?php
                }

                $_SESSION["id_name"] = $_POST["username"];
                $_SESSION["role"] = 1;
                ?>
                    <script>
                        
                        const Toast = Swal.mixin({
                            timer: 1000,
                            timerProgressBar: true
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'เข้าสู่ระบบสำเร็จ'
                        })
                        setTimeout(()=>{window.location.href = "show_result.php"},1000);
                    </script>
                <?php
                //echo $row["ชื่อ"].' '.$row["สกุล"].$chk_password; //debug เฉยๆ :)
            }
            $pw = $_POST["password"];
            $sql = "SELECT * FROM teacher_info WHERE ชื่อ='$user' and รหัสวิชา='$pw' "; //ค้นหา เลขประจำตัว ที่เหมือนกับ ที่รับค่าเข้ามา;
            $result = $db->query($sql);

            if($result->num_rows>=1){ // role = 1 คือ นักเรียน role = 2 คือ ครู role = 3 คือ root
                $_SESSION["id_name"] = "Undefined";
                $_SESSION["teacher_name"] = $_POST["username"];
                $_SESSION["role"] = 2;
                ?>
                    <script>
                        
                        const Toast = Swal.mixin({
                            timer: 1000,
                            timerProgressBar: true
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'เข้าสู่ระบบสำเร็จ'
                        })
                        setTimeout(()=>{window.location.href = "teacher_page.php"},1000);
                    </script>
                <?php
            }else{
                $_SESSION["role"] = -1;
                ?>
                    <script>
                        const Toast = Swal.mixin({
                            timer: 1000,
                            timerProgressBar: true
                        })
                        
                    
                        Toast.fire({
                            icon: 'error',
                            title: 'ชื่อผู้ใช้/รหัสผ่าน ไม่ถูกต้อง'
                        })

                        setTimeout(()=>{window.location.href = "index.php"},1000);
                    </script>
                <?php
            }
        }
    ?>
</body>
<footer style="margin-top:3rem;background-color:rgb(0,0,0,0.025);padding-top:1.5rem;padding-bottom:1.5rem" class="container-fluid">
    <center>
        <p style="margin-bottom:0;">โรงเรียนเบญจมราชูทิศ เลขที่ 159 หมู่ที่ 3 ถนนนาพรุ-ท่าแพ ตำบลโพธิ์เสด็จ อำเภอเมือง จังหวัดนครศรีธรรมราช 80000</p>
        <p style="margin-top:0;">ออกแบบและพัฒนาระบบ โดย นายธีร์จุฑา ศรีวรานนท์ ติดต่อ <a href="mailto:teejuta.sriwaranon@gmail.com">teejuta.sriwaranon@gmail.com</a> <a href="tel:0646548946">0646548946</a></p>
    </center>
</footer>
</body>
</html>