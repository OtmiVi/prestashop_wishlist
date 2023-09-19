
<button class="wishlist-button">
    {if $customer.is_logged}
        {l s='Add to wishlist' mod='wishlist'}
    {else}
        <a href={$link->getPageLink('my-account')} target="_blank">
            {l s='Add to wishlist' mod='wishlist'}
        </a>
    {/if}
</button>