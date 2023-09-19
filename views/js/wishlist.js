$(document).ready(function(){
    $('.wishlist-button').on('click', function (e){
        e.preventDefault();
        let productId = $(this).closest('.js-product-miniature').data('idProduct');

        console.log(productId);
    });
});