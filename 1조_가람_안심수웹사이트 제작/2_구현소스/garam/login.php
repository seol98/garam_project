<?php
include "const.php";

  $uid   = $_POST["ID"];
  $pass = $_POST["PW"];

  //db저장
  //mysql 연결
  $con = $mysqlConnect;
  $sql = "select * from members where uid='$uid'";
  $result = mysqli_query($con, $sql);

  $num_match = mysqli_num_rows($result);

   if(!$num_match) 
   {
     echo("
           <script>
             window.alert('등록되지 않은 아이디입니다!')
             history.go(-1)
           </script>
         ");
    }
    else
    {
        $row = mysqli_fetch_array($result);
        $db_pass = $row["pass"];

        mysqli_close($con);

        if($pass != $db_pass)
        {
           echo("
              <script>
                window.alert('비밀번호가 틀립니다!')
                history.go(-1)
              </script>
           ");
           exit;
        }
        else
        {
            session_start();
            $_SESSION["userid"] = $row["uid"];
            $_SESSION["usernickname"] = $row["nickname"];
            $_SESSION["userwater"] = $row["bottledwater"];
            $_SESSION["useremail"] = $row["email"];
            $_SESSION["userlevel"] = $row["level"];

            echo("
              <script>
                location.href = 'index.php';
              </script>
            ");
        }
   }        
?>
