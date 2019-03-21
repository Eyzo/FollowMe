var cardContainer = document.querySelector('.card-container');

var cards = cardContainer.querySelectorAll('.card');

var documentHeight = document.body.clientHeight;

var windowHeight = document.documentElement.clientHeight;

var basPage = (documentHeight - windowHeight);

var ajaxStatus = false;

document.addEventListener('scroll', ()=> {

    if (window.scrollY >= basPage)  {

        if (!ajaxStatus)
        {
            getAjax('/generateElement/' + (cards.length - 6),function (response) {

                let datas = JSON.parse(response);

                for (data in datas) {

                    let card = createCard(datas[data].name,datas[data].description);

                    cardContainer.appendChild(card);

                }

                basPage = document.body.clientHeight - document.documentElement.clientHeight;

                ajaxStatus = true;

            });
        }
    }
});

