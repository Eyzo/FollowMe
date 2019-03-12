let buttonUnfollow = document.querySelectorAll('#button-error');

buttonUnfollow.forEach((element)=> {

    element.addEventListener('click',(e) => {

        e.preventDefault();

        let url = e.target.getAttribute("href");

        getAjax(url,(response) => {

            response = JSON.parse(response);

            let oldHref = e.target.href;

            let newHref = oldHref.replace('unsubscribe','subscribe');

            let texte = document.createTextNode('Follow');

            let a = document.createElement('a');

            a.classList.add('btn','btn-success');
            a.id = 'button-success';
            a.href = newHref;
            a.appendChild(texte);

            e.target.parentNode.replaceChild(a,e.target);

            let regex = /[0-9]+/;

            let followersDom =  a.parentNode.parentNode.parentNode.querySelector('.text-muted');

            let nbFollowersText = a.parentNode.parentNode.parentNode.querySelector('.text-muted').innerHTML;

            let nombreFollowers =  parseInt(nbFollowersText[nbFollowersText.search(regex)]);

            nbFollowersNewText = document.createTextNode(nbFollowersText.replace(regex,nombreFollowers - 1));

            followersDom.innerHTML = '';

            followersDom.appendChild(nbFollowersNewText);


        });

    })
});