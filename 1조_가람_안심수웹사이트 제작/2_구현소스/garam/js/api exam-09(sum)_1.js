// 해당 동의 정수장 찾기
async function fetchPageData(page) {
try {
  const apiUrl = `https://apis.data.go.kr/B500001/rwis/waterQuality/supplyLgldCode/list?pageNo=${page}&_type=json&numOfRows=300&serviceKey=T3eYs8%2F1d15VzjK4kqIUpWixzEPaaiXRm9a9bQRrf%2FYGvRfZhzpI9reKLehq4qKnz42nBqJx0Qi1FhSJZn%2BhIQ%3D%3D`;
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
 const pageNumbers = Array.from({ length: pageCount }, (_, index) => index + 1);
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
 // 데이터를 성공적으로 불러온 경우, 원하는 작업 수행
 console.log(data);
} else {
 console.log('데이터를 불러오는데 실패하였습니다.');
}
});
