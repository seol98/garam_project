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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>안심수</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <link rel="stylesheet" href="./css/common.css" />
    <link rel="stylesheet" href="./css/header.css" />
    <link rel="stylesheet" href="./css/section_1.css" />
    <!-- <link rel="stylesheet" href="./css/section_2.css" /> -->
    <!-- <link rel="stylesheet" href="./css/section_3.css" /> -->
    <link rel="stylesheet" href="./css/footer.css" />
    <link rel="stylesheet" type="text/css" href="./css/admin.css">

    <!-- 스와이퍼 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- 제이쿼리 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-latest.min.js" type="application/javascript"></script>
    <script type="application/javascript" src="./js/hangjungdong.js"></script>
</head>
<body>
    <header>
            <div class="header_wrapper">
                <div class="gnb">
        <?php
            if(!$userid){
        ?>
                    <a href="#" class="gnb_menu">
                        <img src="./img/lnb_1.png" alt="lang" />
                        <div>Language</div>
                    </a>
                    <a href="#" class="gnb_menu">
                        <img src="./img/lnb_2.png" alt="lang" />
                        <div>Login</div>
                    </a>
        <?php
            }else{
        ?>
                    <a href="#" class="gnb_menu">
                        <img src="./img/lnb_1.png" alt="lang" />
                        <div>Language</div>
                    </a>
                    <a href="./logout.php" class="gnb_menu">
                        <img src="./img/lnb_2.png" alt="lang" />
                        <div>Logout</div>
                    </a>
                    <a href="./member_modify_form.php" class="gnb_menu">
                        <img src="./img/lnb_2.png" alt="lang" />
                        <div>My Page</div>
                    </a>
        <?php
                }
        ?>
                </div>

                <div class="Title_space">
                    <div class="toggle_btn">
                        <input type="checkbox" name="toggle" id="toggle" />
                        <label for="toggle">
                            <img src="./img/btn.png" alt="toggle_img" />
                        </label>
                        <!-- 토글 메뉴 -->
                        <div class="toggle_bar">
                            <div class="toggle_close">
                                <label for="toggle">
                                    <img
                                        src="./img/X_btn.png"
                                        alt="toggle_img"
                                    />
                                </label>
                            </div>
                            <a href="#">상수도 정보</a>
                            <a href="#">샘물 정보</a>
                            <a href="#">랭킹</a>
                            <a href="#">게시판</a>
                            <a href="#">이벤트/공모</a>
                            <a href="#">광고문의</a>
                        </div>
                    </div>

                    <div class="title_Logo">
                        <a href="./index.php"
                            ><img src="./img/main_logo.png" alt=""
                        /></a>
                    </div>

                    <div class="user_menu_mobile">
                        <input
                            type="checkbox"
                            name="user_toggle"
                            id="user_toggle"
                        />
                        <label class="user_toggle_btn" for="user_toggle">
                            <img src="./img/lnb_2.png" alt="user_toggle_img" />
                        </label>
                        <div class="user_toggle_bar">
                            <!-- USER 토글 메뉴 -->
                            <div class="user_toggle_close">
                                <label for="user_toggle">
                                    <img
                                        src="./img/X_btn.png"
                                        alt="user_toggle_img"
                                    />
                                </label>
                            </div>
                            <a href="./index.php">로그인</a>
                            <a href="./Sign_up.php">회원가입</a>
                            <a href="./member_modify_form.php">마이페이지</a>
                            <a href="./member_modify_form.php">개인정보수정</a>
                            <a href="#">마이리스트</a>
                        </div>
                    </div>
                </div>

                <!-- <form class="search_space">
                    <div class="search_bar">
                        <input
                            type="text"
                            name="search_text"
                            id="search_text"
                            placeholder="지역, 샘물 검색"
                        />
                        <img
                            id="search_icon"
                            src="./img/search.svg"
                            alt="search_ico"
                        />
                    </div>
                </form> -->
            </div>
    </header>

    <section class="section_1">
        <div class="section_1_wrapper">
            <div id="admin_box">
                <h3 id="member_title">
                    관리자 모드 > 회원 관리
                </h3>
                <ul id="member_list">
                    <li>
                        <span class="col1">번호</span>
                        <span class="col6">아이디</span>
                        <span class="col3">닉네임</span>
                        <span class="col6">나의 물 정보</span>
                        <span class="col5">레벨</span>
                        <span class="col7">수정</span>
                        <span class="col8">삭제</span>
                    </li>
                    <?php
                        $sql = "select * from members order by num desc";
                        $result = mysqli_query($con, $sql);
                        $total_record = mysqli_num_rows($result); // 전체 회원 수

                        $number = $total_record;

                        while ($row = mysqli_fetch_array($result))
                        {
                            $num         = $row["num"];
                            $uid          = $row["uid"];
                            $nickname        = $row["nickname"];
                            $bottledwater       = $row["bottledwater"];
                            $level       = $row["level"];
                            $regist_day  = $row["regist_day"];
                    ?>
                    <li>
                        <form method="post" action="admin_member_update.php?num=<?=$num?>">
                            <span class="col1"><?=$num?></span>
                            <span class="col6"><?=$uid?></a></span>
                            <span class="col3"><?=$nickname?></span>
                            <span class="col6"><?=$bottledwater?></span>
                            <span class="col5"><input type="text" name="level" value="<?=$level?>"></span>
                            <span class="col7"><button type="submit">수정</button></span>
                            <span class="col8"><button type="button" onclick="location.href='admin_member_delete.php?num=<?=$num?>'">삭제</button></span>
                        </form>
                    </li>	
                    <?php
                        $number--;
                        }
                    ?>
                </ul>
            </div> <!-- admin_box -->
        </div>
    </section> 

    <footer>
        <div class="ft_wrapper">

            <div class="ft_title">
                <span class="ft_title_1">개인정보처리방침</span>
                <span class="ft_title_2">자주하는 질문</span>
            </div>

            <div class="ft_main_logo">
            <img src="./img/ft_main_logo.png" alt="ft_logo">
            </div>

            <div class="ft_content">
                <div class="ft_contents">
                    <ul>
                        <li>
                        (41166)대국광역시 동구 화랑로 525 영진직업전문학교
                        TEL:053-983-8877 FAX:053-722-2423 
                        사업자번호: 502-95-07029701-835 
                        copyright © 대구국비지원 무료교육센터 영진직업전문학교 
                        ALL Rights Reserved.
                        </li>
                    </ul>
                </div>

                <div class="ft_sns">
                    <img src="./img/ft_logo_blog.png" alt="">
                    <img src="./img/ft_logo_facebook.png" alt="">
                    <img src="./img/ft_logo_kakao.png" alt="">
                    <img src="./img/ft_logo_insta.png" alt="">
                    <img src="./img/ft_logo_youtube.png" alt="">
                </div>
            </div>

        </div>
    </footer>

</body>
</html>