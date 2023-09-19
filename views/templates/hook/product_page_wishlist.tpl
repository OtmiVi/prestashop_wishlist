
{if $customer.is_logged}
    <button class="wishlist-button" data-id-product={$product.id_product}>
        add to wishlist
    </button>
{else}
    <button class="wishlist-button-not-login" >
        <a href={$link->getPageLink('my-account')} target="_blank">
            add to wishlist
        </a>
    </button>
{/if}