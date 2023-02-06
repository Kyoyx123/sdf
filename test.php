<?php
$id = $_GET['id'];
$code = $_GET['code'];
include("../index_exam/connectdb.php");
session_start();
$sql = "SELECT * FROM tb_member INNER JOIN tb_student_level ON tb_member.member_id=tb_student_level.member_id where tb_member.member_code='" . $_SESSION['username'] . "'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$student = $row['student_level'];

if ($row['member_code'] == '') {
    $sql = "SELECT * FROM tb_member where member_code='" . $_SESSION['username'] . "'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $conn->close();
}

if ($_SESSION['username'] != $row['member_code'] || $_SESSION['username'] == '') {
    header("location:../index_exam/index_exam.php?id=$id");
    exit();
}

$num = $row['member_code'];
?>
<!DOCTYPE html>
<!--=== Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="test.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Certificate</title>

    <link rel="icon" href="../images/technic1.png">
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src='<?php if ($row['member_img'] == '') echo '../images/img_avatar.png';
                                        else echo '../../Page/student/uploads/' . $row['member_img']; ?>' >
            </div>

            <span class="logo_name"><?php echo $row['member_code'] ?></span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="test.php?id=<?php echo $id ?>&code=<?php echo $code ?>">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">หน้าแรก</span>
                    </a></li>
                <li><a href="../certificate/certificat.php?id=<?php echo $id ?>&code=<?php echo $code ?>">
                        <i class="uil uil-files-landscapes"></i>
                        <span class="link-name">เกียรติบัตร</span>
                    </a></li>
                <!-- <li><a href="#">
                        <i class="uil uil-chart"></i>
                        <span class="link-name">Analytics</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-thumbs-up"></i>
                        <span class="link-name">Like</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-comments"></i>
                        <span class="link-name">Comment</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-share"></i>
                        <span class="link-name">Share</span>
                    </a></li> -->
            </ul>

            <ul class="logout-mode">
                <li><a href="../../Page/student/student_page.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">ออก</span>
                    </a></li>

                <li class="mode">
                    <a href="">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">เปลี่ยนธีม</span>
                    </a>

                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>

                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                    <i class="uil uil-search"></i>
                    <input type="text" placeholder="Search here...">
                </div>

             <img src='<?php if ($row['member_img'] == '') echo '../images/img_avatar.png';
                                        else echo '../../Page/student/uploads/' . $row['member_img']; ?>'>
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">เกียรติบัตร</span>
                </div>
                <?php
                $sql = "SELECT * FROM score where student_id = $num";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                ?>
                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-thumbs-up"></i>
                        <span class="text">แบบทดสอบที่คุณทำ</span>
                        <span class="number"><?php echo $count ?> ครั้ง</span>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">เกียร์ติบัตรที่รับได้</span>
                        <span class="number">20,120</span>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-share"></i>
                        <span class="text">Total Share</span>
                        <span class="number">10,120</span>
                    </div>
                </div>
            </div>

            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">แบบทดสอบที่คุณเคยทำ</span>
                </div>
                <div class="activity-data">
                    <div class="data names">
                        <span class="data-title">รหัสประจำตัว</span>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <span class="data-list"><?php echo $row['student_id'] ?></span>
                        <?php } ?>
                    </div>
                    <div class="data email">
                        <span class="data-title">ชื่อ-นามสกุล</span>
                        <?php
                        $sql2 = "SELECT * FROM score where student_id = $num";
                        $result2 = mysqli_query($conn, $sql2);
                        ?>
                        <?php while ($name = mysqli_fetch_assoc($result2)) { ?>
                            <span class="data-list"><?php echo $name['title'] . " " . $name['firstname'] . " " . $name['lastname'] ?></span>
                        <?php } ?>
                    </div>
                    <div class="data joined">
                        <span class="data-title">ชื่อแบบทดสอบ</span>
                        <?php
                        $sql3 = "SELECT * FROM score inner join ceate_quiz where student_id = $num and score.quiz_id = ceate_quiz.id ";
                        $result3 = mysqli_query($conn, $sql3);
                        ?>
                        <?php while ($quizname = mysqli_fetch_assoc($result3)) { ?>
                            <span class="data-list"><?php echo $quizname['quizname'] ?></span>
                        <?php } ?>
                    </div>
                    <div class="data type">
                        <?php
                        $sql4 = "SELECT * FROM score inner join ceate_quiz where student_id = $num and score.quiz_id = ceate_quiz.id ";
                        $result4 = mysqli_query($conn, $sql4);
                        ?>
                        <span class="data-title">คะแนน</span>
                        <?php while ($score = mysqli_fetch_assoc($result4)) { ?>
                            <span class="data-list"><?php echo $score['score'] . "/" . $score['quantity'] ?></span>
                        <?php } ?>
                    </div>
                    <?php

                    $sql5 = "SELECT score.student_id , score.title , score.firstname , score.lastname , ceate_quiz.quizname ,score.score , ceate_quiz.quantity,tb_member.member_firstname,tb_member.member_lastname,tb_member.member_title
                    FROM ((score
                    LEFT JOIN ceate_quiz ON score.quiz_id = ceate_quiz.id)
                    RIGHT JOIN tb_member ON ceate_quiz.tb_member = tb_member.member_id)
                    WHERE score.student_id = 64201280008";

                    $result5 = mysqli_query($conn, $sql5);
                    ?>
                    <div class="data status">
                        <span class="data-title">ผู้สร้างแบบทดสอบ</span>
                        <?php while ($teacher = mysqli_fetch_assoc($result5)) { ?>
                            <span class="data-list"><?php echo $teacher['member_title']." ".$teacher['member_firstname']." ".$teacher['member_lastname']?></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="test.js"></script>
</body>

</html>