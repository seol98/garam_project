<?php
include "const.php";

    $uid   = $_POST["ID"];
    $pass = $_POST["PW"];
    $nickname = $_POST["Nickname"];
    $email  = $_POST["Email"];
    $tel  = $_POST["Tel"];
    $birth  = $_POST["Birth"];
    $address = $_POST["address_1"]." ".$_POST["address_2"]." ".$_POST["extr_info"];

    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

    //db저장
    //mysql 연결
    $con = $mysqlConnect;

    $sql = "insert into members(uid, pass, nickname, email, tel, birth, address, bottledwater, regist_day, level,login_div)";
	$sql .= "values('$uid', '$pass', '$nickname', '$email', '$tel', '$birth', '$address', '생수', '$regist_day', 9, 0)";

	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
    mysqli_close($con);     

    echo "
	      <script>
	          location.href = 'index.php';
	      </script>
	  ";
?>

   
