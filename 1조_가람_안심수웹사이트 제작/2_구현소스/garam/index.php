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
     else $userlevel = "";
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
    <link rel="stylesheet" href="./css/section_2.css" />
    <link rel="stylesheet" href="./css/section_3.css" />
    <link rel="stylesheet" href="./css/footer.css" />

    <!-- 스와이퍼 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- 제이쿼리 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-latest.min.js" type="application/javascript"></script>
    <script type="application/javascript" src="./js/hangjungdong.js"></script>
    <script type="application/javascript">
        jQuery(document).ready(function() {
            //sido option 추가
            jQuery.each(hangjungdong.sido, function(idx, code) {
                //append를 이용하여 option 하위에 붙여넣음
                jQuery("#sido").append(fn_option(code.sido, code.codeNm));
            });

            //sido 변경시 시군구 option 추가
            jQuery("#sido").change(function() {
                jQuery("#sigugun").show();
                jQuery("#sigugun").empty();
                jQuery("#sigugun").append(fn_option("", "선택")); //
                jQuery.each(hangjungdong.sigugun, function(idx, code) {
                    if (
                        jQuery("#sido > option:selected").val() == code.sido
                    )
                        jQuery("#sigugun").append(
                            fn_option(code.sigugun, code.codeNm)
                        );
                });
            });

            //시군구 변경시 행정동 옵션추가
            jQuery("#sigugun").change(function() {
                //option 제거
                jQuery("#dong").empty();
                jQuery.each(hangjungdong.dong, function(idx, code) {
                    if (
                        jQuery("#sido > option:selected").val() ==
                        code.sido &&
                        jQuery("#sigugun > option:selected").val() ==
                        code.sigugun
                    )
                        jQuery("#dong").append(
                            fn_option(code.dong, code.codeNm)
                        );
                });
                //option의 맨앞에 추가
                jQuery("#dong").prepend(fn_option("", "선택"));
                //option중 선택을 기본으로 선택
                jQuery('#dong option:eq("")').attr("selected", "selected");
            });

            jQuery("#dong").change(function() {
                var sido = jQuery("#sido option:selected");
                var sigugun = jQuery("#sigugun option:selected");
                var dong = jQuery("#dong option:selected");

                // 시도/시군구/읍면동 이름
                var dongName =
                    sido.text() + " " + sigugun.text() + " " + dong.text();
                jQuery("#dongName").text(dongName);

                console.log(dongName);

                /* 공급지역 정수장 찾기 */
                if (dongName) {
                    async function fetchPageData(page) {
                        try {
                            const apiUrl =
                                `https://apis.data.go.kr/B500001/rwis/waterQuality/supplyLgldCode/list?pageNo=${page}&_type=json&numOfRows=300&serviceKey=T3eYs8%2F1d15VzjK4kqIUpWixzEPaaiXRm9a9bQRrf%2FYGvRfZhzpI9reKLehq4qKnz42nBqJx0Qi1FhSJZn%2BhIQ%3D%3D`;
                            const response = await fetch(apiUrl);

                            if (!response.ok) {
                                throw new Error(`API 호출에 실패하였습니다. (페이지: ${page})`);
                            }

                            return response.json();
                        } catch (error) {
                            console.error(error);
                            return null;
                        }
                    }

                    // 여러 페이지 데이터를 한꺼번에 불러오는 함수
                    async function fetchAllPagesData(pageCount) {
                        try {
                            const pageNumbers = Array.from({
                                length: pageCount
                            }, (_, index) => index + 1);
                            const promises = pageNumbers.map(fetchPageData);
                            const allData = await Promise.all(promises);

                            // 여러 페이지 데이터를 하나의 배열로 합치기
                            const mergedData = allData.flat(); // flat() 메서드를 사용해 배열들을 하나로 합칩니다.

                            return mergedData;
                        } catch (error) {
                            console.error(error);
                            return null;
                        }
                    }

                    // 페이지 개수를 설정하고 데이터 불러오기
                    const pageCount = 3; // 예시로 3개 페이지를 불러오도록 설정
                    fetchAllPagesData(pageCount).then((data) => {
                        if (data) {
                            const sumData = data[0] + data[1] + data[2]
                            // 데이터를 성공적으로 불러온 경우, 원하는 작업 수행
                            const result = data[0].response.body.items.item.find(element => element
                                .lgldFullAddr === dongName)
                            console.log(result.fcltyMngNm)

                            let jongsujang = document.getElementById("jongsujang")
                            jongsujang.textContent = result.fcltyMngNm
                        } else {
                            console.log('데이터를 불러오는데 실패하였습니다.');
                        }
                    });
                }
                if (jongsujang) {
                    async function fetchPageData1(page1) {
                        try {
                            const apiUrl1 =
                                `http://apis.data.go.kr/B500001/rwis/waterQuality/list?_type=json&stDt=2023-07-23&stTm=00&edDt=2023-07-23&edTm=24&liIndDiv=1&numOfRows=100&pageNo=${page1}&serviceKey=T3eYs8%2F1d15VzjK4kqIUpWixzEPaaiXRm9a9bQRrf%2FYGvRfZhzpI9reKLehq4qKnz42nBqJx0Qi1FhSJZn%2BhIQ%3D%3D`;
                            const response1 = await fetch(apiUrl1);

                            if (!response1.ok) {
                                throw new Error(`API 호출에 실패하였습니다. (페이지: ${page1})`);
                            }

                            return response1.json();
                        } catch (error) {
                            console.error(error);
                            return null;
                        }
                    }

                    // 여러 페이지 데이터를 한꺼번에 불러오는 함수
                    async function fetchAllPagesData1(pageCount1) {
                        try {
                            const pageNumbers1 = Array.from({
                                length: pageCount1
                            }, (_, index) => index + 1);
                            const promises1 = pageNumbers1.map(fetchPageData1);
                            const allData1 = await Promise.all(promises1);

                            // 여러 페이지 데이터를 하나의 배열로 합치기
                            const mergedData1 = allData1.flat(); // flat() 메서드를 사용해 배열들을 하나로 합칩니다.

                            return mergedData1;
                        } catch (error) {
                            console.error(error);
                            return null;
                        }
                    }

                    // 페이지 개수를 설정하고 데이터 불러오기
                    const pageCount1 = 9; // 예시로 9개 페이지를 불러오도록 설정
                    fetchAllPagesData1(pageCount1).then((data1) => {
                        if (data1) {
                            const sumData = data1[0] + data1[1] + data1[2] + data1[3] + data1[4] +
                                data1[5] + data1[6] + data1[7] + data1[8]
                            // 데이터를 성공적으로 불러온 경우, 원하는 작업 수행
                            const result1 = data1[0].response.body.items.item.find(element =>
                                element.fcltyMngNm === jongsujang);
                            console.log(result1.clVal)
                            console.log(result1.phVal)
                            console.log(result1.clVal)

                            let cl = document.getElementById("cl")
                            cl.textContent = result1.clVal
                            let ph = document.getElementById("ph")
                            ph.textContent = result1.phVal
                            let tb = document.getElementById("tb")
                            tb.textContent = result1.tbVal
                        } else {
                            console.log('데이터를 불러오는데 실패하였습니다.');
                        }
                    });
                }
            });
        });

        function fn_option(code, name) {
            return '<option value="' + code + '">' + name + "</option>";
        }

        function fn_iframe(url) {
            jQuery("#iframe").attr("src", url);
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
                    <a href="./member_modify_form.php" class="gnb_menu">
                        <img src="./img/lnb_2.png" alt="lang" />
                        <div>My Page</div>
                    </a>
                <?php
                        }
                ?>
                <?php
                    if($userlevel==1) {
                ?>
                    <a href="./admin.php" class="gnb_menu">
                        <img src="./img/lnb_2.png" alt="lang" />
                        <div>Admin</div>
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
    <!-- 바디시작  -->
    <!--  -->
    <!--  -->

    <section class="section_1">
        <div class="section_1_wrapper">
            <!--  -->
            <!-- 왼쪽 -->
            <!--  -->

            <div class="section_1_item_1">
                <div class="item_1_titleline">
                    <div class="item_1_title">
                        <img src="./img/st_logo.png" alt="title_head" />
                        <div id="dongName"></div>
                        <div>수질정보</div>
                    </div>
                    <div class="location_select_btn">
                        <a href="#">
                            <img src="./img/st_wheel.png" alt="" />
                            <div>지역선택</div>
                        </a>
                    </div>
                </div>

                <div class="item_1_contents">
                    <!-- 수원지 지역선택 -->
                    <div>
                        <form>
                            <select id="sido">
                                <option value="">선택</option>
                            </select>
                            <select id="sigugun">
                                <option value="">선택</option>
                            </select>
                            <select id="dong">
                                <option value="">선택</option>
                            </select>
                            <input type="submit" value="적용" />
                        </form>
                    </div>

                    <!-- 수원지 정보 -->
                    <div class="item_1_contents_box_1">
                        <div class="contents_box1_1">
                            <img src="./img/content_1_icon_1.png" alt="" />
                            <div>OO댐</div>
                        </div>
                        <div class="contents_box1_2">
                            <img src="./img/content_1_icon_2.png" alt="" />
                            <div id="jongsujang"></div>
                        </div>
                        <div class="contents_box1_3">
                            <img src="./img/content_1_icon_3.png" alt="" />
                            <div>OO배수지</div>
                        </div>
                        <div class="contents_box1_4">
                            <img src="./img/content_1_icon_4.png" alt="" />
                            <div>OO동</div>
                        </div>
                    </div>

                    <!-- 수원지 수질정보 -->
                    <div class="item_1_contents_box_2">
                        <div class="contents_box_2_item">
                            <div id="tb">탁도</div>
                            <div>그래프</div>
                            <div>수치</div>
                        </div>
                        <div class="contents_box_2_item" id="cl">잔류염소</div>
                        <div class="contents_box_2_item" id="ph">수소이온농도</div>
                    </div>
                </div>
            </div>

            <!--  -->
            <!-- 오른쪽 -->
            <!--  -->
            <div class="section_1_item_2">
                <?php
                    if(!$userid){
                ?>
                    <!-- 로그인 안했을때 -->
                    <div class="item_2_logout">
                        <div class="item_2_area">
                            <div class="box_1">
                                <div class="box_1_text">
                                    <div class="box_1_text_Mobile">
                                        <div>나만의&nbsp;</div>
                                        <div>
                                            <span class="drop_splash">
                                                샘물
                                                <img
                                                    src="./img/st_mini_logo.png"
                                                    alt=""
                                                />
                                            </span>
                                            정보를
                                        </div>
                                    </div>
                                    <div>등록하세요!</div>
                                </div>
                                <button class="box_1_btn" id="hideButton">
                                    로그인 / 회원가입
                                </button>
                            </div>
                    
                            <div class="box_2">
                                <div class="box_2_login_form">
                                    <div class="login_form_title">
                                        <img
                                            src="./img/st_logo.png"
                                            alt="title_head"
                                        />
                                        <div>로그인</div>
                                    </div>
                                    <form method="post" name="login_form" action="./login.php">
                                        <div class="input_wrapper">
                                            <div class="login_input">
                                                <div>아이디</div>
                                                <input type="text" name="ID"/>
                                            </div>
                                            <div class="login_input">
                                                <div>패스워드</div>
                                                <input type="password" name="PW"/>
                                            </div>
                                        </div>
                                        <input class="iogin_btn" type="submit" value="로그인" style="cursor: pointer"/>
                                    </form>
                                    <div>
                                        <div class="signin_area">
                                            <a href="./Sign_up.php">회원가입</a>
                                            <p>|</p>
                                            <a href="#">아이디·패스워드 찾기</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="box_2_social_loginform">
                                    <div class="login_form_title">
                                        <img src="./img/st_logo.png" alt="title_head"/>
                                        <div class="">SNS 로그인</div>
                                    </div>
                                    <div class="SNS_login_btn">
                                        <a href=<?php echo SocialLogin::socialLoginUrl("kakao") ?>
                                            ><img
                                                src="./img/sns_api_kakao.png"
                                                alt="kakao_login"
                                        /></a>
                                        <a href=<?php echo SocialLogin::socialLoginUrl("naver") ?>
                                            ><img
                                                src="./img/sns_api_naver.png"
                                                alt="naver_login"
                                        /></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }else{
                ?>
                <!--  -->
                <!-- 로그인 했을때 -->
                <!--  -->
                <div class="item_2_login">
                    <div class="item_2_titleline">
                        <div class="item_2_title">
                            <img src="./img/st_logo.png" alt="title_head" />
                            <div>샘물정보</div>
                        </div>
                        <div class="location_select_btn">
                            <a href="#">
                                <img src="./img/st_wheel.png" alt="" />
                                <div>마이페이지</div>
                            </a>
                        </div>
                        <?php
                            //mysql 연결
                            // include "const.php";
                            $con = $mysqlConnect;
                            $sql = "select * from members where uid='$userid'";
                            $result = mysqli_query($con, $sql);
                            $row    = mysqli_fetch_array($result);

                            $nickname = $row["nickname"];
                            $bottledwater = $row["bottledwater"];

                            mysqli_close($con);

                            echo $nickname." 님의 샘물정보입니다";
                        ?>
                    </div>
                    <div class="item_2_contents_wrapper">
                        <div class="item_2_contents">

                            <!-- 개인샘물정보 연동한 쇼핑데이터 -->
                            <?php
                                $encText = urlencode("$bottledwater");
                                $url = "https://openapi.naver.com/v1/search/shop?query=".$encText."&display=3"; // json 결과
                                //  $url = "https://openapi.naver.com/v1/search/blog.xml?query=".$encText; // xml 결과
                                $is_post = false;
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_POST, $is_post);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $headers = array();
                                $headers[] = "X-Naver-Client-Id: ".$client_id;
                                $headers[] = "X-Naver-Client-Secret: ".$client_secret;
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                $response = curl_exec ($ch);
                                $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                //   echo "status_code:".$status_code."<br>";
                                curl_close ($ch);
                                if($status_code == 200) {

                                    $json_result = json_decode($response, true);

                                    foreach($json_result['items'] as $items){

                                        $title = $items['title']; //상품이름
                                        $link = $items['link']; //상품정보 URL
                                        $image = $items['image']; //섬네일 이미지
                                        $lprice = $items['lprice']; //최저가
                                        $brand = $items['brand']; //브랜드
                                        $maker = $items['maker']; //제조사
                                        $mallName = $items['mallName']; //판매처(쇼핑몰)

                                        
                                        echo "
                                        <div class='item_2_box item_2_box_1'>
                                                <!-- [link] -->
                                                <a href='$link'>
                                                    <div class='item_2_box_thumbnail'>
                                                        <!-- [image] -->
                                                        <img src='$image' alt='' />
                                                    </div>
                                                    <div class='item_2_box_detail'>
                                                        <div class='product_info'>
                                                            <!-- [title] -->
                                                            <div class='product_name'>
                                                            $brand
                                                            </div>
                                                            <!-- [brand] -->
                                                            <div class='product_brand'>
                                                            $title
                                                            </div>
                                                        </div>
                                                        <div class='product_price'>
                                                            <!-- mallname -->
                                                            <div class='mall'>$mallName</div>
                                                            <div class='price'>
                                                                <!-- iprice -->
                                                                <div>$lprice</div>
                                                                <div>&nbsp;원</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        ";
                                    }
                                } else {
                                    echo "Error 내용:".$response;
                                }
                            ?>  
                                <div class="item_2_box item_2_box_4 nolist">
                                    <img src="./img/Add_product_btn.png" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        <div class="scroll_guide">
            <img src="./img/scroll_guide.png" alt="" />
        </div>
    </section>

    <section class="section2">
        <div class="st2_title">
             <p><span>물 소식<img src="./img/st_mini_logo.png"></span></p>
        </div>
    
        <div class="st2_wrapper">
            <!-- Slider main container -->
            <div class="swiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide bg1"><a href="https://ilovewater.or.kr/web"></a></div>
                <div class="swiper-slide bg2"><a href="https://www.water.or.kr/kor/contest/index.do?menuId=17_293"></a></div>
                <div class="swiper-slide bg3"><a href="https://www.water.or.kr/kor/board/index.do?bid=BD_00017&mode=view&menuId=17_189&wid=110475"></a></div>
    
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
            
                <!-- If we need navigation buttons -->
                <!-- <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div> -->
            
                <!-- If we need scrollbar -->
                <!-- <div class="swiper-scrollbar"></div> -->
            </div> 
    
            <div class="st2_inner">
                <div class="st2_contens">
                    <div class="ct_title">
                        <ul>
                            <li><a href="">공지사항</a></li>
                            <li><a href="">소셜&뉴스</a></li>
                            <li><a href="">행사&공모</a></li>
                            <p><a href="">더보기+</a></p>
                        </ul>
                            
                    </div>
    
                     <div class="ct_contents">
                        <div class="ct_1">
                            <div class="ct_1-1">
                                <p>07</p>
                                <p>20</p>
                            </div>
                            <p class="ct_p">'무라벨 생수' 무기질 함량은 어디에?</p>
                        </div>
                        <p class="ct_s_p">-무라벨생수,무기질 및 제조업체 확인 어려워&middot;&middot;&middot;</p>
                     </div>
                     
                     <div class="ct_2">
                        <ul>
                            <li>&#8226;&nbsp;먹는샘물 총대장균군&middot;크롬 등 '세균'범벅<span>2023-07-19</span></li>
                            <li>&#8226;&nbsp;수질부적합 생수를 '무라벨'로 판매한다고?<span>2023-07-19</span></li>
                            <li>&#8226;&nbsp;무라벨생수'무기질함량은 어디에?<span>2023-07-19</span></li>
                        </ul>
                     </div>
    
                     <div class="ct_2_but">
                        <button>+ 더보기</button>
                     </div>
                </div>
            </div>     
        </div>
      
    </section>

    <section class="section3">
        <div class="st2_title">
            <p><span>안심수의 추천<img src="./img/st_mini_logo.png"></span></p>
       </div>
    
        <div class="st3_contens">
            <!-- 1번째 -->
            <div class="st3_wrapper">
                
                    <div class="st3_img">
                        <img src="./img/117263_195183_3720 1.png" >
                    </div>
    
                <div class="st3_teex">
                    <div class="st3_txt">
                        <p>연세대학교</p>
                        <p>울릉해양심층수</p>
                    </div>
    
                    <div class="st3_txt2">
                        <p>500ml * 20</p>
                    </div>
    
                    <div class="st3_price_1">
                        <img src="./img/Coupang.png">
                        <p>14,800<span>원</span></p>
                    </div>
                </div>
                <div class="AD">AD</div>
            </div>
    
            <!-- 2번째 -->
            <div class="st3_wrapper">   
                <div class="st3_img">
                    <img src="./img/image 26.png" >
                </div>
    
            <div class="st3_teex">
                <div class="st3_txt">
                    <p class="st3_txt_p">스파클 무라벨</p>
                </div>
    
                <div class="st3_txt2">
                    <p class="st3_txt2_p">500ml * 40</p>
                </div>
    
                <div class="st3_price">
                    <button>가격 비교</button>
                </div>
            </div>
        </div>
    
        <!-- 3번째 -->
        <div class="st3_wrapper"> 
                <div class="st3_img">
                    <img src="./img/image 26.png" >
                </div>
    
            <div class="st3_teex">
                <div class="st3_txt">
                    <p class="st3_txt_p">스파클 무라벨</p>
                </div>
    
                <div class="st3_txt2">
                    <p class="st3_txt2_p">500ml * 40</p>
                </div>
    
                <div class="st3_price">
                    <button>가격 비교</button>
                </div>
            </div>
        </div>
    
    
    
        <div class="ct_2_but2">
            <button>+ 더보기</button>
        </div>
    
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

    <!--  -->
    <!-- 이벤트  -->
    <!--  -->

         <!-- 스와이퍼 -->
         <script src="./js/swiper.js"></script>

    <!-- 스크롤로 헤더 조절 -->
    <script>
    window.addEventListener("scroll", function() {
        const searchSpace = document.querySelector(".search_space");

        if (window.scrollY > 64) {
            searchSpace.classList.add("hidden"); // 스크롤 시 클래스 추가하여 숨김
        } else {
            searchSpace.classList.remove("hidden"); // 스크롤이 위로 올라갈 때 클래스 제거하여 표시
        }
    });
    </script>

    <!-- 클릭으로 페이지 조절 -->
    <script>
    const hideButton = document.getElementById("hideButton");
    const box1 = document.querySelector(".box_1");

    hideButton.addEventListener("click", function() {
        box1.style.display = "none"; // 버튼 클릭 시 box_1의 너비를 0으로 설정
    });
    </script>



    <!-- 가격표시 판매자 로고로 바꾸기 -->
    <script>
    const mallElement1 = document.querySelector(".item_2_box_1 .mall");
    const mallElement2 = document.querySelector(".item_2_box_2 .mall");
    const mallElement3 = document.querySelector(".item_2_box_3 .mall");
    const mallElement4 = document.querySelector(".item_2_box_4 .mall");

    if (mallElement1.textContent.trim() === "cupang") {
        mallElement1.innerHTML =
            '<img src="./img/shoplogo_cupang.png" alt="Cupang Image" />';
    } else if (mallElement1.textContent.trim() === "11th") {
        mallElement1.innerHTML =
            '<img src="./img/shoplogo_11th.png" alt="Cupang Image" />';
    }

    if (mallElement2.textContent.trim() === "cupang") {
        mallElement2.innerHTML =
            '<img src="./img/shoplogo_cupang.png" alt="Cupang Image" />';
    } else if (mallElement2.textContent.trim() === "11st") {
        mallElement2.innerHTML =
            '<img src="./img/shoplogo_11st.png" alt="11st Image" />';
    }

    if (mallElement3.textContent.trim() === "cupang") {
        mallElement3.innerHTML =
            '<img src="./img/shoplogo_cupang.png" alt="Cupang Image" />';
    } else if (mallElement3.textContent.trim() === "11st") {
        mallElement3.innerHTML =
            '<img src="./img/shoplogo_11st.png" alt="11st Image" />';
    }
    </script>
</body>

</html>