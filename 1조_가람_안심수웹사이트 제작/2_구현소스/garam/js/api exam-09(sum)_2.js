async function fetchPageData1(page1) {
try {
const apiUrl1 = `http://apis.data.go.kr/B500001/rwis/waterQuality/list?_type=json&stDt=2023-07-23&stTm=00&edDt=2023-07-23&edTm=24&liIndDiv=1&numOfRows=100&pageNo=${page1}&serviceKey=T3eYs8%2F1d15VzjK4kqIUpWixzEPaaiXRm9a9bQRrf%2FYGvRfZhzpI9reKLehq4qKnz42nBqJx0Qi1FhSJZn%2BhIQ%3D%3D`;
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
const pageNumbers1 = Array.from({ length: pageCount1 }, (_, index) => index + 1);
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
// 데이터를 성공적으로 불러온 경우, 원하는 작업 수행
console.log(data1);
} else {
console.log('데이터를 불러오는데 실패하였습니다.');
}
});