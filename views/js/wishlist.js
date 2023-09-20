$(document).ready(function(){
    $('.wishlist-button').on('click', function (e){
        e.preventDefault();
        let productId = $(this).closest('.js-product-miniature').data('idProduct');

        $.ajax({
            type: 'POST',
            url: url,
            datatype: 'json',
            data: {
                productId: productId,
                ajax: 1,
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