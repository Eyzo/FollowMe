function getAjax(url,response) {

    let request = new XMLHttpRequest();

    request.open('GET',url);

    request.addEventListener('load',() => {
        
        if (request.status >= 200 && request.status < 400) {

            response(request.response);

        } else {

            console.log('il y a eu erreur au niveau du client');

        }
        
    });

    request.addEventListener('error',() => {

        console.log('il y a eu une erreur serveur');

    });

    request.send();

}