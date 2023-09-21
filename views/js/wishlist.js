$(document).ready(function(){
    $('.wishlist-button, .wishlist-button-remove').on('click', function (e){
        e.preventDefault();
        let button = $(this);
        let productId = button.closest('.js-product-miniature').data('idProduct');
        let action = button.hasClass('wishlist-button') ? 'add' : 'remove';


        $.ajax({
            type: 'POST',
            url: url,
            datatype: 'json',
            data: {
                productId: productId,
                ajax: 1,
                action: action,
            },
            success: function(jsonData)
            {
                if (action === 'add') {
                    console.log('add');
                } else {
                    console.log('remove');
                    console.log(jsonData);
                }
               changeStatus(button);
            },
            error: function(error)
            {
                console.log(error);
            }
        });
    });

    function changeStatus(button){
        button.toggleClass('wishlist-button wishlist-button-remove');
    }
});