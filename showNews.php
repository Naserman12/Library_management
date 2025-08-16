<style>
    
.news-container{
   margin-bottom: 10px;
    height: 70px;
    width:95%;
    margin: 50px auto;
    text-align: center;
    padding: 20px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
}
.news-item{
    margin-bottom: 10px;
    font-size: 16px;
    color: #333;
    height: 100%;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../admin/styleAdmin.css"> -->
    <title>الأخبار</title>
</head>
<body>

    <div class="news-container">
        <!-- <h1> اخر التحديثات</h1> -->
        <div id="news-item" class="news-item">
        </div>
    </div>
    <script>
//  هذا المغير سيحدد القسم الذي سوف يعرض
let newsItem = document.getElementById('news-item');
// متغير لتتبع القسم
let currentNewsIndex = 0;
let currentContentIndex = 0;
// دالة لتحديث الأخبار على الشاشة
function updateNews(newsData){
    if (!Array.isArray(newsData) || newsData.length === 0) {
    console.error('لا توجد بيانات أخبار صحيحة');
    return; // الخروج من الدالة إذا كانت البيانات غير صحيحة
}
    let news = newsData[currentNewsIndex];
    let newsType = news.type;
    let contentItem = news.content[currentContentIndex]
    // الحصول على القسم الحالي
        newsHTML = `<h2>${newsType}</h2>`;
           
            newsHTML += `<p>${contentItem.title} - ${contentItem.author}<p> `;
            
       
        // تحديث المحتوى على الصفحة
        newsItem.innerHTML = newsHTML;
        // تحديث المحتوى على الصفحة
        currentContentIndex++
        if(currentContentIndex >= news.content.length){
            currentContentIndex = 0;
            currentNewsIndex = (currentNewsIndex + 1) % newsData.length; // الانتقال للقسم التالي
        }
    }
        function fetchNews(){
            fetch('fetchNews.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
            console.log(data)
        })
          .then(data =>{
            console.log(data); 
              if(data.newsData){
                  updateNews(data.newsData);  
            }else{
                console.error('لم يتم العثور على المصفوفة.')
            }  
           
        })
        .catch(error => console.error('Error fetching News: ', error));         
    }
    // console.log(newsData)
    fetchNews(); //جلب البانات عند تحميل الصفحة 
    // تحديث الدالة تلقائقيا كل 5 ثواني
    setInterval(fetchNews, 3000);
    </script>
</body>
</html>