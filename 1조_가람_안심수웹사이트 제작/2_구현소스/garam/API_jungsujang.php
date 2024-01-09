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
    <!-- <link rel="stylesheet" href="./css/section_3.css" /> -->
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
                        
                       for(let i=0; i<=data1.length; i++){
                            const result1 = data1[i].response.body.items;
                            for(let i2=0; i2<=100; i2++){
                                const result2 = result1.item[i2];
                                const result3 = result2.fcltyMngNm;
                                const result4 = result2.find(e=>e.fcltyMngNm === result.fcltyMngNm)
                                console.log(result4.clVal)
                            }

                            // console.log(result3.clVal);
                       }
                        


                        // const sumData = data1[0] + data1[1] + data1[2] + data1[3] + data1[4] +
                        //     data1[5] + data1[6] + data1[7] + data1[8]
                        // 데이터를 성공적으로 불러온 경우, 원하는 작업 수행
                        // const result1 = data1[0].response.body.items.item[0];
                        // const result2 = result1.fcltyMngNm;

                        // const result3 = result1.find

                        // const result1 = data1[0].response.body.items.item[0].find(element =>
                        //     element.fcltyMngNm === jongsujang);
                        // console.log(result1.clVal)
                        // console.log(result1.phVal)
                        // console.log(result1.clVal)
                        

                        // let cl = document.getElementById("cl")
                        // cl.textContent = result1.clVal
                        // let ph = document.getElementById("ph")
                        // ph.textContent = result1.phVal
                        // let tb = document.getElementById("tb")
                        // tb.textContent = result1.tbVal
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
<section class="section_1">
    <div class="section_1_wrapper">
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
        </div>
    </section>
</body>