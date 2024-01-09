<?php
    include "const.php";

    $userid   = $_POST["ID"];

    $pass = $_POST["PW"];
    $nickname = $_POST["Nickname"];
    $email  = $_POST["Email"];
    $tel  = $_POST["Tel"];
    // $birth  = $_POST["Birth"];
    $address = $_POST["address_1"]." ".$_POST["address_2"]." ".$_POST["extr_info"];
    
    $bottledwater  = $_POST["bottledwater"];

    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
          
    // echo $userid."<br>";
    // echo $pass."<br>";
    // echo $nickname."<br>";
    // echo $email."<br>";
    // echo $tel."<br>";
    // // echo $birth;
    // echo $address."<br>";
    // echo $bottledwater."<br>";

    // db저장
    // mysql 연결
    $con = $mysqlConnect;

    $sql = "update members set pass='$pass', nickname='$nickname', email='$email', tel='$tel', address='$address', bottledwater='$bottledwater', regist_day='$regist_day'";
    $sql .= " where uid='$userid'";
    mysqli_query($con, $sql);

    mysqli_close($con);  
    
    echo "
	      <script>
	          location.href = 'index.php';
	      </script>
	  ";
?>
