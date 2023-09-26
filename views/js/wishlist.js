$(document).ready(function () {
    $('.wishlist-button, .wishlist-button-remove').on('click', function (e) {
        e.preventDefault();
        let button = $(this);
        button.prop('disabled', true);
        let id_product = button.closest('.js-product-miniature').data('idProduct');
        let id_product_attribute = button.closest('.js-product-miniature').data('idProductAttribute');
        let action = button.hasClass('wishlist-button') ? 'add' : 'remove';


        $.ajax({
            type: 'POST',
            url: url,
            datatype: 'json',
            data: {
                id_product: id_product,
                id_product_attribute: id_product_attribute,
                ajax: 1,
                action: action,
            },
            success: function (jsonData) {
                console.log(jsonData);
                changeStatus(button, action);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('.wishlist-product-button, .wishlist-product-button-remove').on('click', function (e) {
        e.preventDefault();
        let button = $(this);
        button.prop('disabled', true);
        let id_product = button.data('idProduct');
        let id_product_attribute = button.data('idProductAttribute');
        let action = button.hasClass('wishlist-product-button') ? 'add' : 'remove';


        $.ajax({
            type: 'POST',
            url: url,
            datatype: 'json',
            data: {
                id_product: id_product,
                id_product_attribute: id_product_attribute,
                ajax: 1,
                action: action,
            },
            success: function (jsonData) {
                console.log(jsonData);
                changeStatusProductPage(button, action);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('.wishlist-list-remove').on('click', function (e) {
        e.preventDefault();
        let button = $(this);
        let id_product = button.data('idProduct');
        let id_product_attribute = button.data('idProductAttribute');

        $.ajax({
            type: 'POST',
            url: url,
            datatype: 'json',
            data: {
                id_product: id_product,
                id_product_attribute: id_product_attribute,
                ajax: 1,
                action: 'remove',
            },
            success: function (jsonData) {
                removeProductFromList(button);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('.wishlist-add-to-cart').on('click', function (e) {
        e.preventDefault();
        let id_product = $(this).data('idProduct');
        let id_product_attribute = $(this).data('idProductAttribute');
        let quantity = 1;
        const token = prestashop.static_token;
        const url = prestashop.urls.pages.cart;
        const query = 'add=1&action=update&ajax=true&token=' + token + '&id_product=' + id_product + '&id_product_attribute=' + id_product_attribute + '&qty=' + quantity;
        var controllerUrl = url.concat(query);
        var functionName = "addToCart";

        $.ajax({
            cache: false,
            data: query,
            success: function (resp) {
                prestashop.emit('updateCart', {
                    reason: {
                        idProduct: resp.id_product,
                        idProductAttribute: resp.id_product_attribute
                    }, resp: resp
                });
            },
            error: function (resp) {
                prestashop.emit('handleError', {eventType: 'addProductToCart', resp: resp});
            }
        })
    });

    function removeProductFromList(button) {
        button.closest('.wishlist_item').remove();
    }

    function changeStatus(button, action) {
        button.toggleClass('wishlist-button wishlist-button-remove');
        if (action === 'add') {
            button.text(remove_button);
        } else {
            button.text(add_button);
        }
        button.prop('disabled', false);
    }

    function changeStatusProductPage(button, action) {
        button.toggleClass('wishlist-product-button wishlist-product-button-remove');
        if (action === 'add') {
            button.text(remove_button);
        } else {
            button.text(add_button);
        }
        button.prop('disabled', false);
    }

    var slideIndex = 0;
    var slideWidth = $(".wishlist_item").outerWidth();
    var itemsPerSlide = 3;

    // Next Slide
    $(".next-slide").click(function () {
        slideIndex++;
        var maxIndex = $(".wishlist_item").length - itemsPerSlide;
        if (slideIndex > maxIndex) {
            slideIndex = 0;
        }
        var translateX = -slideIndex * slideWidth;
        $(".wishlist-items").css("transform", "translateX(" + translateX + "px)");
    });

    // Previous Slide
    $(".prev-slide").click(function () {
        slideIndex--;
        if (slideIndex < 0) {
            slideIndex = $(".wishlist_item").length - itemsPerSlide;
        }
        var translateX = -slideIndex * slideWidth;
        $(".wishlist-items").css("transform", "translateX(" + translateX + "px)");
    });

});