$(document).ready(function(){
    $('.wishlist-button').on('click', function (e){
        e.preventDefault();
        let productId = $(this).closest('.js-product-miniature').data('idProduct');

        console.log(productId);

        $.ajax({
            type: 'POST',
            url: 'http://presta8/uk/module/wishlist/add',
            datatype: 'json',
            data: {
                productId: productId,
                action: 'add',
            },
            success: function(jsonData)
            {
               console.log(jsonData);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                console.log(XMLHttpRequest);
            }
        });
    });
});