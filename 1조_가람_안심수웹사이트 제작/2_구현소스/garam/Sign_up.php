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
        <link rel="stylesheet" href="./css/common.css" />
        <link rel="stylesheet" href="./css/header.css" />
        <link rel="stylesheet" href="./css/Sign_up.css" />
        <link rel="stylesheet" href="./css/footer.css" />
        <title>안심 수</title>

        <script>
            function check_input()
            {
                if (!document.Sign_in.ID.value) {
                    alert("아이디를 입력하세요!");    
                    document.Sign_in.ID.focus();
                    return;
                }

                if (!document.Sign_in.PW.value) {
                    alert("비밀번호를 입력하세요!");    
                    document.Sign_in.PW.focus();
                    return;
                }

                if (!document.Sign_in.PW_check.value) {
                    alert("비밀번호확인을 입력하세요!");    
                    document.Sign_in.PW_check.focus();
                    return;
                }

                if (document.Sign_in.PW.value != 
                        document.Sign_in.PW_check.value) {
                    alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
                    document.Sign_in.PW.focus();
                    document.Sign_in.PW_check.value = "";
                    document.Sign_in.PW.select();
                    return;
                }

                if (!document.Sign_in.Nickname.value) {
                    alert("닉네임을 입력하세요!");    
                    document.Sign_in.Nickname.focus();
                    return;
                }

                if (!document.Sign_in.Email.value) {
                    alert("이메일 주소를 입력하세요!");    
                    document.Sign_in.Email.focus();
                    return;
                }

                if (!document.Sign_in.Tel.value) {
                    alert("전화번호를 입력하세요!");    
                    document.Sign_in.Tel.focus();
                    return;
                }
                
                document.Sign_in.submit();
            }

            function reset_form() {
                document.Sign_in.ID.value = "";  
                document.Sign_in.PW.value = "";
                document.Sign_in.PW_check.value = "";
                document.Sign_in.Nickname.value = "";
                document.Sign_in.Email.value = "";
                document.Sign_in.Tel.value = "";
                document.Sign_in.ID.focus();
                return;
            }

            function check_id() {
                window.open("member_check_id.php?id=" + document.Sign_in.ID.value,
                    "IDcheck",
                    "left=700,top=300,width=350,height=200,scrollbars=no,resizable=yes");
            }
        </script>
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
                    <a href="./member_modify_form_form.php" class="gnb_menu">
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
                            <a href="./member_modify_form_form.php">마이페이지</a>
                            <a href="./member_modify_form_form.php">개인정보수정</a>
                            <a href="#">마이리스트</a>
                        </div>
                    </div>
                </div>

                <form class="search_space">
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
                </form>
            </div>
        </header>

        <!--  -->
        <!--  -->
        <!--  -->

        <div class="Page_wrapper">
            <div class="Title">
                <div class="Title_container">
                    <div>회원가입</div>
                    <img src="./img/st_mini_logo.png" alt="" />
                </div>
            </div>
            <div class="Dir">
                홈&nbsp;&nbsp;&nbsp;>&nbsp;&nbsp;&nbsp;회원가입
            </div>
            <div class="sign-in_notice">
                * 표시된 항목은 필수입력 항목입니다.
            </div>
            <div class="sign-in_Form">
                <form name="Sign_in" method="post" action="./member_insert.php">
                    <div class="sign-in_field">
                        <div class="sign-in_Required">아이디</div>
                        <input name="ID" id="ID" type="text" />
                    </div>

                    <div class="sign-in_field">
                        <div class="sign-in_Required">비밀번호</div>
                        <input name="PW" id="PW" type="password" />
                    </div>

                    <div class="sign-in_field">
                        <div class="sign-in_Required">비밀번호 확인</div>
                        <input name="PW_check" id="PW_check" type="password" />
                    </div>

                    <div class="sign-in_field">
                        <div class="sign-in_Required">닉네임</div>
                        <input name="Nickname" id="Nickname" type="text" />
                    </div>

                    <div class="sign-in_field">
                        <div class="sign-in_Required">이메일</div>
                        <input name="Email" id="Email" type="email" />
                    </div>

                    <div class="sign-in_field">
                        <div class="sign-in_Required">전화번호</div>
                        <input name="Tel" id="Tel" type="text" />
                    </div>

                    <div class="sign-in_field">
                        <div>생년월일</div>
                        <input name="Birth" id="Birth" type="text" maxlength="6" placeholder="생년월일 6자리 입력"/>
                    </div>
                    <!-- 회원가입 양식 : 성별 hidden -->
                    <!-- <div class="sign-in_field">
                        <div>성별</div>
                        <div class="sign-in_GenderSelect">
                            <div>
                                <input
                                    name="Gender"
                                    id="Gender_Notselect"
                                    type="radio"
                                    value="not_checked"
                                    checked="checked"
                                />
                                <label for="Gender_Notselect"> 선택안함 </label>
                            </div>
                            <div>
                                <input
                                    name="Gender"
                                    id="Gender_Male"
                                    type="radio"
                                    value="male"
                                />
                                <label for="Gender_Male"> 남성 </label>
                            </div>
                            <div>
                                <input
                                    name="Gender"
                                    id="Gender_Female"
                                    type="radio"
                                    value="Female"
                                />
                                <label for="Gender_Female"> 여성 </label>
                            </div>
                            <div>
                                <input
                                    name="Gender"
                                    id="Gender_Other"
                                    type="radio"
                                    value="Other"
                                />
                                <label for="Gender_Other"> 이외 </label>
                            </div>
                        </div>
                    </div> -->

                    <!-- 다음 우편번호 서비스 -->
                    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
                    <script>
                        function sample6_execDaumPostcode() {
                            new daum.Postcode({
                                oncomplete: function(data) {
                                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                    var addr = ''; // 주소 변수
                                    var extraAddr = ''; // 참고항목 변수

                                    //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                        addr = data.roadAddress;
                                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                        addr = data.jibunAddress;
                                    }

                                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                                    if(data.userSelectedType === 'R'){
                                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                                        if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                                            extraAddr += data.bname;
                                        }
                                        // 건물명이 있고, 공동주택일 경우 추가한다.
                                        if(data.buildingName !== '' && data.apartment === 'Y'){
                                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                        }
                                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                                        if(extraAddr !== ''){
                                            extraAddr = ' (' + extraAddr + ')';
                                        }
                                        // 조합된 참고항목을 해당 필드에 넣는다.
                                        document.getElementById("extr_info").value = extraAddr;
                                    
                                    } else {
                                        document.getElementById("extr_info").value = '';
                                    }

                                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                                    document.getElementById('zipcode').value = data.zonecode;
                                    document.getElementById("address_1").value = addr;
                                    // 커서를 상세주소 필드로 이동한다.
                                    document.getElementById("Address_2").focus();
                                }
                            }).open();
                        }
                    </script>
                    <div class="sign-in_field">
                        <div>주소</div>
                        <div class="sign-in_Address">
                            <div class="sign-in_Address_zipcode">
                                <input name="zipcode" id="zipcode" type="text" disabled/>
                                <button type="button" onclick="sample6_execDaumPostcode()">우편번호검색</button>
                            </div>
                            <div class="sign-in_Address_address">
                                <input name="address_1" id="address_1" type="text"/>
                                <div>상세주소 입력</div>
                                <input name="address_2" id="Address_2" type="text"/>
                                <input type="hidden" name="extr_info" id="extr_info">
                            </div>
                        </div>
                    </div>
                    <div class="sign-in_field">
                        <div class="sign-in_Required">나의 물 정보</div>
                        <input name="bottledwater" id="bottledwater" type="text" placeholder="(ex. 삼다수, 백산수 등)" />
                    </div>
                    <div class="sign-up_btns">
                        <input type="button" value="회원가입" onclick="check_input()" style="cursor:pointer"/>
                        <a href="#"><input type="button" value="취소" style="cursor:pointer" onclick="reset_form()"/></a>
                    </div>
                </form>
            </div>
        </div>

        <footer>
            <div class="ft_wrapper">
                <div class="ft_title">
                    <span class="ft_title_1">개인정보처리방침</span>
                    <span class="ft_title_2">자주하는 질문</span>
                </div>

                <div class="ft_main_logo">
                    <img src="./img/ft_main_logo.png" alt="ft_logo" />
                </div>

                <div class="ft_content">
                    <div>
                        <ul>
                            <li>
                                (41166)대국광역시 동구 화랑로 525
                                영진직업전문학교 <br />
                                TEL:053-983-8877 FAX:053-722-2423 <br />
                                사업자번호: 502-95-07029701-835 <br />
                                copyright © 대구국비지원 무료교육센터
                                영진직업전문학교 <br />
                                ALL Rights Reserved.
                            </li>
                        </ul>
                    </div>

                    <div class="ft_sns">
                        <img src="./img/ft_logo_blog.png" alt="" />
                        <img src="./img/ft_logo_facebook.png" alt="" />
                        <img src="./img/ft_logo_kakao.png" alt="" />
                        <img src="./img/ft_logo_insta.png" alt="" />
                        <img src="./img/ft_logo_youtube.png" alt="" />
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
