<?php
$ch = curl_init();
$url = 'http://apis.data.go.kr/1480523/Dwqualityservice/getDrinkWaterTKAWY'; /*URL*/
$queryParams = '?' . urlencode('serviceKey') . '=HJ7ZGPx9iDuXTY50FfpMkImzOTWMbkCo6KJBZgSv%2BsK3%2BPjAWJCmqARQ0XIKT7u9z812boJvUSFcN9JNmhAkqQ%3D%3D'; /*Service Key*/
$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /**/
$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('4000'); /**/
// $queryParams .= '&' . urlencode('search_year') . '=' . urlencode('2019'); /**/
// $queryParams .= '&' . urlencode('search_ht') . '=' . urlencode('01'); /**/
// $queryParams .= '&' . urlencode('search_mgc') . '=' . urlencode('경기도'); /**/

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);

$xml = simplexml_load_string($response);
$json = json_encode($xml);
$json_result = json_decode($json, true);

foreach($json_result['body']['items']['item'] as $waterDataTotal){
        $year = $waterDataTotal['year']; //년도
        $qu = $waterDataTotal['qu']; //분기
        $mgc = $waterDataTotal['mgc']; //관리기관명
        $entrpsNm = $waterDataTotal['entrpsNm']; //업체명
        $prductNm = $waterDataTotal['prductNm']; //제품명
        $chckDe = $waterDataTotal['chckDe']; //수질검사 검사일자
        $pcbacStbltAt = $waterDataTotal['pcbacStbltAt']; //일반세균(저온) 적합여부
        $msbacStbltAt = $waterDataTotal['msbacStbltAt']; //일반세균(중온) 적합여부
        $tcoliStbltAt = $waterDataTotal['tcoliStbltAt']; //총대장균군 적합여부
        $fcstrStbltAt = $waterDataTotal['fcstrStbltAt']; //분원성연쇄상구균 적합여부
        $psaerStbltAt = $waterDataTotal['psaerStbltAt']; //녹농균 적합여부
        $smnlaStbltAt = $waterDataTotal['smnlaStbltAt']; //살모넬라 적합여부
        $shglaStbltAt = $waterDataTotal['shglaStbltAt']; //쉬겔라 적합여부
        $sfsraStbltAt = $waterDataTotal['sfsraStbltAt']; //아황산환원혐기성포자형성균 적합여부
        $pbStbltAt = $waterDataTotal['pbStbltAt']; //납 적합여부
        $flrnStbltAt = $waterDataTotal['flrnStbltAt']; //불소 적합여부
        $asStbltAt = $waterDataTotal['asStbltAt']; //비소 적합여부
        $slnumStbltAt = $waterDataTotal['slnumStbltAt']; //셀레늄 적합여부
        $mrcStbltAt = $waterDataTotal['mrcStbltAt']; //수은 적합여부
        $cynStbltAt = $waterDataTotal['cynStbltAt']; //시안 적합여부
        $crStbltAt = $waterDataTotal['crStbltAt']; //크롬 적합여부
        $nh4nStbltAt = $waterDataTotal['nh4nStbltAt']; //암모니아성 질소 적합여부
        $cdmmStbltAt = $waterDataTotal['cdmmStbltAt']; //카드뮴 적합여부
        $boronStbltAt = $waterDataTotal['boronStbltAt']; //보론 적합여부
        $brmtStbltAt = $waterDataTotal['brmtStbltAt']; //브론산염 적합여부
        $phnlStbltAt = $waterDataTotal['phnlStbltAt']; //페놀 적합여부
        $diaznStbltAt = $waterDataTotal['diaznStbltAt']; //다이아지논 적합여부
        $prtoStbltAt = $waterDataTotal['prtoStbltAt']; //파라티온 적합여부
        $fntrtoStbltAt = $waterDataTotal['fntrtoStbltAt']; //페니트로티온 적합여부
        $cbrylStbltAt = $waterDataTotal['cbrylStbltAt']; //카바릴 적합여부
        $trch111StbltAt = $waterDataTotal['trch111StbltAt']; //1.1.1-트리클로로에탄 적합여부
        $ttcelStbltAt = $waterDataTotal['ttcelStbltAt']; //테트라클로로에틸렌 적합여부
        $tceStbltAt = $waterDataTotal['tceStbltAt']; //트리클로로에틸렌 적합여부
        $dcmStbltAt = $waterDataTotal['dcmStbltAt']; //디클로로메탄 적합여부
        $c6h6StbltAt = $waterDataTotal['c6h6StbltAt']; //벤젠 적합여부
        $tlnStbltAt = $waterDataTotal['tlnStbltAt']; //톨루엔 적합여부
        $chchStbltAt = $waterDataTotal['chchStbltAt']; //에틸벤젠 적합여부
        $zylnStbltAt = $waterDataTotal['zylnStbltAt']; //크실렌 적합여부
        $dch11StbltAt = $waterDataTotal['dch11StbltAt']; //1.1디클로로에틸렌 적합여부
        $cbttcStbltAt = $waterDataTotal['cbttcStbltAt']; //사염화탄소 적합여부
        $db12ch3StbltAt = $waterDataTotal['db12ch3StbltAt']; //1,2-디브로모-3-클로로프로판 적합여부
        $diox14StbltAt = $waterDataTotal['diox14StbltAt']; //1,4-다이옥산 적합여부
        $hdnswatStbltAt = $waterDataTotal['hdnswatStbltAt']; //경도 적합여부
        $ppconStbltAt = $waterDataTotal['ppconStbltAt']; //과망간산칼륨소비량 적합여부
        $smellStbltAt = $waterDataTotal['smellStbltAt']; //냄새 적합여부
        $copprStbltAt = $waterDataTotal['copprStbltAt']; //동 적합여부
        $chmaStbltAt = $waterDataTotal['chmaStbltAt']; //색도 적합여부
        $anosurStbltAt = $waterDataTotal['anosurStbltAt']; //세제 적합여부
        $phStbltAt = $waterDataTotal['phStbltAt']; //수소이온농도 적합여부
        $zincStbltAt = $waterDataTotal['zincStbltAt']; //아연 적합여부
        $chloionStbltAt = $waterDataTotal['chloionStbltAt']; //염소이온 적합여부
        $seasnStbltAt = $waterDataTotal['seasnStbltAt']; //철 적합여부
        $mangStbltAt = $waterDataTotal['mangStbltAt']; //망간 적합여부
        $turStbltAt = $waterDataTotal['turStbltAt']; //탁도 적합여부
        $slftionStbltAt = $waterDataTotal['slftionStbltAt']; //황산이온 적합여부
        $almnmStbltAt = $waterDataTotal['almnmStbltAt']; //알루미늄 적합여부
    
        echo "
            검사결과 년도 : $year <br>
            해당 분기 : $qu <br>
            관리기관명 : $mgc <br>
            업체명 : $entrpsNm <br>
            제품명 : $prductNm <br>
            검사일자 : $chckDe <br>
            ======================= <br>
            일반세균(저온) 적합여부 : $pcbacStbltAt <br>
            일반세균(중온) 적합여부 : $msbacStbltAt <br>
            분원성연쇄상구균 적합여부 : $fcstrStbltAt <br>
            녹농균 적합여부 : $psaerStbltAt <br>
            살모넬라 적합여부 : $smnlaStbltAt <br>
            쉬겔라 적합여부 : $shglaStbltAt <br>
            아황산환원혐기성포자형성균 적합여부 : $sfsraStbltAt <br>
            납 적합여부 : $pbStbltAt <br>
            불소 적합여부 : $flrnStbltAt <br>
            비소 적합여부 : $asStbltAt <br>
            셀레늄 적합여부 : $slnumStbltAt <br>
            수은 적합여부 : $mrcStbltAt <br>
            시안 적합여부 : $cynStbltAt <br>
            크롬 적합여부 : $crStbltAt <br>
            암모니아성 질소 적합여부 : $nh4nStbltAt <br>
            카드뮴 적합여부 : $cdmmStbltAt <br>
            보론 적합여부 : $boronStbltAt <br>
            브론산염 적합여부 : $brmtStbltAt <br>
            페놀 적합여부 : $phnlStbltAt <br>
            다이아지논 적합여부 : $diaznStbltAt <br>
            파라티온 적합여부 : $prtoStbltAt <br>
            페니트로티온 적합여부 : $fntrtoStbltAt <br>
            카바릴 적합여부 : $cbrylStbltAt <br>
            1.1.1-트리클로로에탄 적합여부 : $trch111StbltAt <br>
            테트라클로로에틸렌 적합여부 : $ttcelStbltAt <br>
            트리클로로에틸렌 적합여부 : $tceStbltAt <br>
            디클로로메탄 적합여부 : $dcmStbltAt <br>
            벤젠 적합여부 : $c6h6StbltAt <br>
            톨루엔 적합여부 : $tlnStbltAt <br>
            에틸벤젠 적합여부 : $chchStbltAt <br>
            크실렌 적합여부 : $zylnStbltAt <br>
            1.1디클로로에틸렌 적합여부 : $dch11StbltAt <br>
            사염화탄소 적합여부 : $cbttcStbltAt <br>
            1,2-디브로모-3-클로로프로판 적합여부 : $db12ch3StbltAt <br>
            1,4-다이옥산 적합여부 : $diox14StbltAt <br>
            경도 적합여부 : $hdnswatStbltAt <br>
            과망간산칼륨소비량 적합여부 : $ppconStbltAt <br>
            냄새 적합여부 : $smellStbltAt <br>
            동 적합여부 : $copprStbltAt <br>
            색도 적합여부 : $chmaStbltAt <br>
            세제 적합여부 : $anosurStbltAt <br>
            수소이온농도 적합여부 : $phStbltAt <br>
            아연 적합여부 : $zincStbltAt <br>
            염소이온 적합여부 : $chloionStbltAt <br>
            철 적합여부 : $seasnStbltAt <br>
            망간 적합여부 : $mangStbltAt <br>
            탁도 적합여부 : $turStbltAt <br>
            황산이온 적합여부 : $slftionStbltAt <br>
            알루미늄 적합여부 : $almnmStbltAt <br>
            <br>
        ";

}
?>