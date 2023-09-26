{block name="wishlictAddButton"}
    <button class={$class_name}>
        {if $customer.is_logged}
            {if $class_name == "wishlist-button-remove"}
                {l s='Remove from wishlist' mod='wishlist'}
            {else}
                {l s='Add to wishlist' mod='wishlist'}
            {/if}
        {else}
            <a href={$link->getPageLink('my-account')} target="_blank">
                {l s='Add to wishlist' mod='wishlist'}
            </a>
        {/if}
    </button>
{/block}
