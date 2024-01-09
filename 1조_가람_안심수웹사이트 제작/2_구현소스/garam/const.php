<?php
class SocialLogin{
    //프로퍼티
    //* api 키
    private static $kakaoApi = "44bd5c3f79ab3bd69f6cc2a06a5ef0e1";
    private static $googleApi = "525174477529-e9o9j6e0l3or61e0ftih7ncuu4gupho7.apps.googleusercontent.com";
    private static $naverApi = "2wcwnHMfyES7riw109SG";
    //* 시크릿 키
    private static $googleClientSecret = "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";
    private static $naverClientSecret = "pVWd1kgYVl";
   
    //* 접속 url
    private static $redirectUrl = "http://ansimsu.dothome.co.kr/social_login.php";

    static public function socialLoginUrl($loginState){

        switch($loginState){
            case "google":
                return 'https://accounts.google.com/o/oauth2/v2/auth?client_id='.self::$googleApi.'&redirect_uri='.self::$redirectUrl.'&response_type=code&state=google&scope=https://www.googleapis.com/auth/userinfo.email+https://www.googleapis.com/auth/userinfo.profile&access_type=offline&prompt=consent';
            case "kakao":
                return 'https://kauth.kakao.com/oauth/authorize?client_id='.self::$kakaoApi.'&redirect_uri='.self::$redirectUrl.'&response_type=code&state=kakao&prompt=login';
            case "naver":
                return 'https://nid.naver.com/oauth2.0/authorize?client_id='.self::$naverApi.'&redirect_uri='.self::$redirectUrl.'&response_type=code&state=naver';
            default:
                return "";
        }
    }
    static public function getKakaoApi(){
        return self::$kakaoApi;
    }

    static public function getGoogleApi(){
        return self::$googleApi;
    }

    static public function getNaverApi(){
        return self::$naverApi;
    }

    static public function getRedirectUrl(){
        return self::$redirectUrl;
    }

    static public function getGoogleClientSecret(){
        return self::$googleClientSecret;
    }

    static public function getNaverClientSecret(){
        return self::$naverClientSecret;
    }


    
}

$mysqlConnect = mysqli_connect("localhost", "ansimsu", "garam2023!", "ansimsu");
$con = mysqli_connect("localhost", "ansimsu", "garam2023!", "ansimsu");

//네이버 쇼핑검색 api키
$client_id = "I2P4txtOX2v0UEyq_dvA";
$client_secret = "0Nu6qZZPti";

?>