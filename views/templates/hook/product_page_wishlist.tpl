
{if $customer.is_logged}
    <button class="wishlist-button" data-id-product={$product.id_product}>
        {l s='Add to wishlist' mod='wishlist'}
    </button>
{else}
    <button class="wishlist-button-not-login" >
        <a href={$link->getPageLink('my-account')} target="_blank">
            {l s='Add to wishlist' mod='wishlist'}
        </a>
    </button>
{/if}