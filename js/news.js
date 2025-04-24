function displayNews(news){
    const newsContent = document.getElementById('news-content');
    newsContent.innerHTML = '';
    news.forEach(item => {
        const newsItem = `
            <div class="news-item">
                <h3>${item.title}</h3>
                <p>${item.content}</p>
                <p>Дата: ${item.date}</p>
            </div>`;
        newsContent.innerHTML += newsItem;
    });
}