let buttonFollow = document.querySelectorAll('#button-follow');

function eventClick(e) {

        e.preventDefault();

        if (e.target.getAttribute('data-status') === 'active') {

            e.target.setAttribute('data-status','desactive')

        } else if(e.target.getAttribute('data-status') === 'desactive') {

            e.target.setAttribute('data-status','active');

        }

        let url = e.target.getAttribute("href");

        let oldHref = e.target.href;
        let a = document.createElement('a');
        a.id = 'button-follow';

        if (e.target.getAttribute('data-status') === 'desactive') {

            let newHref = oldHref.replace('subscribe','unsubscribe');
            let texte = document.createTextNode('Unfollow');

            a.classList.add('btn','btn-danger');
            a.setAttribute('data-status','desactive');
            a.href = newHref;
            a.appendChild(texte);

        } else {

            let newHref = oldHref.replace('unsubscribe','subscribe');
            let texte = document.createTextNode('Follow');


            a.classList.add('btn','btn-success');
            a.setAttribute('data-status','active');
            a.href = newHref;
            a.appendChild(texte);

        }

        let parentNode = e.target.parentNode;

        parentNode.replaceChild(a,e.target);

        getAjax(url,(response) => {


            response = JSON.parse(response);

            let regex = /[0-9]+/;

            let followersDom =  a.parentNode.parentNode.parentNode.querySelector('.text-muted');

            for (let el in response) {

                if (el === 'count_followers')
                {
                    var nbFollowers = response[el];
                }
            }

            nbFollowersNewText = document.createTextNode(followersDom.innerHTML.replace(regex,nbFollowers));

            followersDom.innerHTML = '';

            followersDom.appendChild(nbFollowersNewText);

        });
}

document.addEventListener('click',(e) => {

    if (e.target && e.target.id === 'button-follow') {

        eventClick(e);

    }

});


