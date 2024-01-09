<?php
    include "const.php";

    // 로그인 정보가 없다면 session_start();
    if (empty($_SESSION["userid"])) session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["usernickname"])) $usernickname = $_SESSION["usernickname"];
    else $usernickname = "";
    if (isset($_SESSION["userwater"])) $userwater = $_SESSION["userwater"];
    else $userwater = "";
    if (isset($_SESSION["useremail"])) $useremail = $_SESSION["useremail"];
    else $useremail = "";
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $usertel = "";

    if ( $userlevel != 1 )
    {
        echo("
            <script>
            alert('관리자가 아닙니다! 회원정보 수정은 관리자만 가능합니다!');
            history.go(-1)
            </script>
        ");
        exit;
    }

    $num   = $_GET["num"];
    $level = $_POST["level"];

    // $con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "update members set level=$level where num=$num";
    mysqli_query($con, $sql);

    mysqli_close($con);

    echo "
	     <script>
	         location.href = 'admin.php';
	     </script>
	   ";
?>

