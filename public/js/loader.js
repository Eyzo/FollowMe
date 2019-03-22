window.onload = function () {

    setTimeout(function () {

        let loader = document.querySelector('.loader');
        loader.style.display = 'none';

        let loaderContainer = loader.parentNode;
        loaderContainer.style.display = 'none';

    },1000)

};