{if empty($data)}
    <p>{l s='You have got no products in wishlist' mod='wishlist'}</p>
{/if}
{foreach from=$data item=item}
    <div class="wishlist_item">
        <img
                src="{$item->image_url}"
                alt="{$item->name}"
                loading="lazy"
                width="100"
                height="100"
        />
        <p>{$item->name}</p>
        <p>{$item->price_static} {$currency.iso_code}</p>

        <button class="wishlist-add-to-cart"
                data-id-product={$item->id} data-id-product-attribute={$item->id_product_attribute}>
            {l s='Add to cart' mod='wishlist'}
        </button>
        <button class="wishlist-list-remove"
                data-id-product={$item->id} data-id-product-attribute={$item->id_product_attribute}>
            {l s='Remove from wishlist' mod='wishlist'}
        </button>
        <hr>
    </div>
{/foreach}