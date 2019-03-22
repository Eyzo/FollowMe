document.addEventListener('DOMContentLoaded',function () {



    let searchUser = document.querySelector('#search-user');

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    searchUser.onkeyup = delay(function (e) {

        let profile = e.target.value;
        let result = document.querySelector('.result');

        result.innerHTML = "";
        
        if (profile != "")
        {

            getAjax('/search_profile/ajax?profile=' + encodeURIComponent(profile),function (response) {

                if (response != "") {


                    let div = document.createElement('div');
                    div.innerHTML = response;
                    div.className = 'resultat';

                    result.appendChild(div);

                } else {

                    result.innerHTML = "<div class='resultat'>Aucun profiles</div>"

                }

            });
        }

    },500);



});