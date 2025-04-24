document.addEventListener('DOMContentLoaded', () => {
    showDate(); // Вызов функции отображения даты при загрузке страницы
    showTime(); // Первичный вызов функции отображения времени
    setInterval(showTime, 1000); // Обновление времени каждую секунду
});

function showTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const timeString = `${hours}:${minutes}:${seconds}`;
    const clockElement = document.getElementById('clock');
    if (clockElement) {
        clockElement.textContent = timeString;
    }
}

function showDate() {
    const today = new Date();
    const weekdays = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
    const dayOfWeek = weekdays[today.getDay()];
    const day = String(today.getDate()).padStart(2, '0');
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const year = today.getFullYear();
    const dateString = `${day}.${month}.${year}, ${dayOfWeek}`;
    const dateElement = document.getElementById('date');
    if (dateElement) {
        dateElement.textContent = dateString;
    }
}

