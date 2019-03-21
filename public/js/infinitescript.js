var elem = document.querySelector('.container');

var infScroll = new InfiniteScroll( elem, {
    // options
    path: function() {
        var cards = document.querySelectorAll('.card');
        var pageNumber = cards.length;
        return '/page/' + pageNumber;
    },
    append: '.card-deck',
    history: false,
});