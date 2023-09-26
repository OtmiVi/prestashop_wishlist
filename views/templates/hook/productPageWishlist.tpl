{block name="productPageWishlist"}
    {if $customer.is_logged}
        <button class="{$class_name}"
                data-id-product={$product.id_product} data-id-product-attribute={$product.id_product_attribute}>
            {if $class_name == "wishlist-product-button-remove"}
                {l s='Remove from wishlist' mod='wishlist'}
            {else}
                {l s='Add to wishlist' mod='wishlist'}
            {/if}
        </button>
    {else}
        <button class="wishlist-button-not-login">
            <a href={$link->getPageLink('my-account')} target="_blank">
                {l s='Add to wishlist' mod='wishlist'}
            </a>
        </button>
    {/if}
{/block}