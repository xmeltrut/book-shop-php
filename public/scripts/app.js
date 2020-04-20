function addToBasket(id) {
    axios.post('/basket/add', { 'id': id })
        .then(function(response) {
            updateBasketUi(response.data);
        });
}

function updateBasket() {
    axios.get('/basket/list')
        .then(function(response) {
            updateBasketUi(response.data);
        })
}

function updateBasketUi(data) {
    const basketUi = document.querySelector('#basket');
    const text = basketUi.querySelector('div');

    if (data.length > 0) {
        const booksText = (data.length === 1) ? 'book' : 'books';
        text.innerHTML = `You have ${data.length} ${booksText} in your basket`;
        basketUi.style.display = 'block';
    } else {
        basketUi.style.display = 'none';
    }
}
