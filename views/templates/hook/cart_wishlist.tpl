{if empty($data)}
    <p>{l s='You have got no products in wishlist' mod='wishlist'}</p>
{else}
    <div class="wishlist-slider">
        <div class="wishlist-items">
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

                </div>
            {/foreach}
        </div>
        <hr>
    </div>
    <button class="prev-slide">Previous</button>
    <button class="next-slide">Next</button>
{/if}