let createCard = function (title,text) {

    let card = document.createElement('div');
    card.className = 'card';

    let img = document.createElement('img');
    img.src = 'https://www.place-hold.it/300x300';
    img.className = 'card-img-top';

    card.appendChild(img);

    let cardBody = document.createElement('div');
    cardBody.classList.add('main-card','card-body');

    card.appendChild(cardBody);

    let cardTitle = document.createElement('h5');
    cardTitle.className = 'card-title';

    let titleText = document.createTextNode(title);

    cardTitle.appendChild(titleText);
    card.appendChild(cardTitle);

    let cardText = document.createElement('p');
    cardText.className = 'card-text';

    let textText = document.createTextNode(text);

    cardText.appendChild(textText);
    card.appendChild(cardText);

    return card;
};