
document.addEventListener('DOMContentLoaded', () => {
    // Инициализация обработчиков кнопок "Добавить в корзину"
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', addToCart);
    });

    // Создание объекта-сравнения для продуктов по ID
    const productsMap = {};
    if (typeof products !== 'undefined' && Array.isArray(products)) {
        products.forEach(product => {
            productsMap[product.id] = product;
        });
    } else {
        console.error("Массив products не определен или имеет неверный формат.");
    }

    // Отображение содержимого корзины
    updateCartDisplay();

    // Обработчик кнопки "Оформить заказ"
    const placeOrderButton = document.getElementById('place-order-button');
    if (placeOrderButton) {
        placeOrderButton.addEventListener('click', toggleOrderForm);
    }

    // Обработчик отправки формы заказа
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', submitOrder);
    }
});

// Функция для добавления товара в корзину
function addToCart(event) {
    const button = event.target;
    const productId = button.dataset.productId;

    if (!productsMap[productId]) {
        alert("Выбранный товар не существует.");
        return;
    }

    const product = productsMap[productId];
    const productName = product.name;
    const productPrice = product.price;
    const productImage = product.image;

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existingItem = cart.find(item => item.id === productId);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: parseFloat(productPrice),
            image: productImage,
            quantity: 1,
            checked: true
        });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

// Функция для обновления отображения корзины
function updateCartDisplay() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartContent = document.getElementById('cart-content');
    cartContent.innerHTML = '';

    if (cart.length === 0) {
        cartContent.innerHTML = '<p>Корзина пуста</p>';
        document.getElementById('order-summary').innerHTML = '';
        return;
    }

    let totalQuantity = 0;
    let totalPrice = 0;

    // Используем DocumentFragment для оптимизации
    const fragment = document.createDocumentFragment();

    cart.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('cart-item');

        // Чекбокс для выбора товара
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = `item-${item.id}`;
        checkbox.dataset.itemId = item.id;
        checkbox.checked = item.checked;
        checkbox.addEventListener('change', updateOrderSummary);
        itemDiv.appendChild(checkbox);

        // Изображение товара
        const img = document.createElement('img');
        img.src = item.image;
        img.alt = item.name;
        img.width = 50;
        itemDiv.appendChild(img);

        // Название товара
        const name = document.createElement('h3');
        name.textContent = item.name;
        itemDiv.appendChild(name);

        // Цена товара
        const price = document.createElement('p');
        price.textContent = ` Цена: ${item.price} р`;
        itemDiv.appendChild(price);

        // Количество товара
        const quantity = document.createElement('p');
        quantity.textContent = `Количество:  ${item.quantity}`;
        itemDiv.appendChild(quantity);

        // Кнопка "Удалить"
        const removeButton = document.createElement('button');
        removeButton.textContent = ' Удалить';
        removeButton.classList.add('remove-from-cart');
        removeButton.dataset.itemId = item.id;
        removeButton.addEventListener('click', removeFromCart);
        itemDiv.appendChild(removeButton);

        fragment.appendChild(itemDiv);

        totalQuantity += item.quantity;
        totalPrice += item.price * item.quantity;
    });

    cartContent.appendChild(fragment);

    // Отображение сводки заказа
    const orderSummary = document.getElementById('order-summary');
    orderSummary.innerHTML = `
        <p>Всего товаров: ${totalQuantity}</p>
        <p>Общая стоимость: ${totalPrice.toFixed(2)} руб.</p>
    `;

    // Обновление сводки заказа с учетом выбранных товаров
    updateOrderSummary();
}

// Функция для удаления товара из корзины
function removeFromCart(event) {
    const productId = event.target.dataset.itemId;
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

// Функция для отображения/скрытия формы заказа
function toggleOrderForm() {
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        if (orderForm.style.display === 'none' || orderForm.style.display === '') {
            orderForm.style.display = 'block';
        } else {
            orderForm.style.display = 'none';
        }
    }
}

// Функция для обновления сводки заказа
function updateOrderSummary() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const checkedItems = cart.filter(item => {
        const checkbox = document.getElementById(`item-${item.id}`);
        return checkbox && checkbox.checked;
    });

    const orderSummary = document.getElementById('order-summary');
    let totalQuantity = 0;
    let total = 0;
    let itemsHTML = '';

    if (checkedItems.length === 0) {
        orderSummary.innerHTML = '<p>Выберите товары для оформления заказа.</p>';
        return;
    }

    checkedItems.forEach(item => {
        total += item.price * item.quantity;
        totalQuantity += item.quantity;
        itemsHTML += `
            <div class="order-item">
                <img src="${item.image}" alt="${item.name}" width="50">
                <p>${item.name} x ${item.quantity} = ${(item.price * item.quantity).toFixed(2)} руб.</p>
            </div>`;
    });

    orderSummary.innerHTML = `
        <h3>Выбранные товары:</h3>
        ${itemsHTML}
        <p>Итого: ${total.toFixed(2)} руб.</p>
        <p>Количество товаров: ${totalQuantity}</p>
    `;
}

// Функция для отправки заказа на сервер
function submitOrder(event) {
    event.preventDefault(); // Предотвращаем стандартную отправку формы

    const formData = new FormData(event.target);
    const orderData = {};
    formData.forEach((value, key) => {
        orderData[key] = value.trim();
    });

    // Валидация ФИО (только русские буквы и пробелы)
    const fioRegex = /^[А-Яа-яЁё\s]+$/u;
    if (!fioRegex.test(orderData.fio)) {
        alert("Введите Имя корректно (только русские буквы и пробелы).");
        return;
    }

    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const checkedItems = cart.filter(item => {
        const checkbox = document.getElementById(`item-${item.id}`);
        return checkbox && checkbox.checked;
    });

    if (checkedItems.length === 0) {
        alert("Пожалуйста, выберите товары для заказа.");
        return;
    }

    // Расчёт итоговой суммы и количества
    let totalAmount = 0;
    let totalQuantity = 0;
    checkedItems.forEach(item => {
        totalAmount += item.price * item.quantity;
        totalQuantity += item.quantity;
    });

    orderData.items = checkedItems.map(item => ({
        id: item.id,
        name: item.name,
        price: item.price,
        quantity: item.quantity
    }));
    orderData.total_amount = totalAmount.toFixed(2);
    orderData.order_date = new Date().toISOString();

    // Отправка данных на сервер
    fetch('process_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData)
    })
    .then(response => {
        // Проверка, что ответ имеет тип application/json
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new TypeError("Ответ сервера не является JSON");
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert("Заказ успешно оформлен!");
            localStorage.removeItem('cart');
            updateCartDisplay();
            event.target.reset();
            toggleOrderForm(); // Закрыть форму после успешного заказа
        } else {
            alert(`Ошибка: ${data.message}`);
        }
    })
    .catch(error => {
        console.error("Ошибка:", error);
        alert("Произошла ошибка при оформлении заказа. Пожалуйста, попробуйте снова.");
    });
}

// Создание глобальной карты продуктов для быстрого доступа
const productsMap = {};
if (typeof products !== 'undefined' && Array.isArray(products)) {
    products.forEach(product => {
        productsMap[product.id] = product;
    });
} else {
    console.error("Массив products не определен или имеет неверный формат.");
}

function getProductName(productId) {
    return productsMap[productId] ? productsMap[productId].name : "Неизвестный товар";
}

function getProductPrice(productId) {
    return productsMap[productId] ? productsMap[productId].price : 0;
}

function getProductImage(productId) {
    return productsMap[productId] ? productsMap[productId].image : "img/default.jpg";
}


