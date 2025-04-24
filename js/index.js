function displayProducts(products) {
    const productGrid = document.getElementById('product-grid');
    productGrid.innerHTML = '';

    if (!Array.isArray(products) || products.length === 0) {
        productGrid.innerHTML = '<p>Нет доступных товаров.</p>';
        return;
    }

    const fragment = document.createDocumentFragment();

    products.forEach(product => {
        const productCard = document.createElement('div');
        productCard.classList.add('product-card');

        const imgContainer = document.createElement('div');
        imgContainer.classList.add('img-container');

        const img = document.createElement('img');
        img.src = product.image;
        img.alt = product.name;
        imgContainer.appendChild(img);
        productCard.appendChild(imgContainer);


        const name = document.createElement('h3');
        name.textContent = product.name;
        productCard.appendChild(name);

        const price = document.createElement('p');
        price.classList.add('price'); 
        price.textContent = `${parseInt(product.price, 10).toLocaleString()} р`;
        productCard.appendChild(price);


        const description = document.createElement('p');
        description.textContent = product.description;
        productCard.appendChild(description);

        const spacer = document.createElement('div');
        spacer.classList.add('spacer');
        productCard.appendChild(spacer);

        const addButton = document.createElement('button');
        addButton.textContent = 'Добавить в корзину';
        addButton.classList.add('add-to-cart');
        addButton.dataset.productId = product.id;
        productCard.appendChild(addButton);

        fragment.appendChild(productCard);
    });

    productGrid.appendChild(fragment);

    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', addToCart);
    });
}
