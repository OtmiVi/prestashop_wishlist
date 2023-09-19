$(document).ready(function(){
    $('.wishlist-button').on('click', function (e){
        e.preventDefault();
        let productId = $(this).parent().parent().parent().data('idProduct');
        console.log(productId);
    });
});