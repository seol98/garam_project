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
    <link rel="stylesheet" href="./css/footer.css" />
</head>
<?php

include "const.php";

  $encText = urlencode("삼다수");
  $url = "https://openapi.naver.com/v1/search/shop?query=".$encText."&display=4"; // json 결과
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
                              $title
                            </div>
                            <!-- [brand] -->
                            <div class='product_brand'>
                              $brand
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



        // echo " 
        //     <a href='$link'><div>
        //         <img src='$image' alt='bottledwater_thumbnail' width='80px'>
        //         <div>$title</div>
        //         <div>$lprice.'원'</div>
        //         <div>'브랜드 :'.$brand</div>
        //         <div>'제조사 :'.$maker</div>
        //         <div>'판매처 :'.$mallName</div>
        //     </div></a>
        // ";
    }
  } else {
    echo "Error 내용:".$response;
  }
?>   
