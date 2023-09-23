
{extends file='customer/page.tpl'}


{block name='page_title'}
    {l s='Wish List' mod='wishlist'}
{/block}

{block name='page_content'}
    {if empty($data)}
        <p>{l s='You have got no products in wishlist' mod='wishlist'}</p>
    {/if}
    {foreach from=$data item=item}

        <div class="item">
            <img
                src="{$item->image_url}"
                alt="{$item->name}"
                loading="lazy"
                width="100"
                height="100"
            />
            <p>{$item->name}</p>
            <p>{$item->price_static} {$currency.iso_code}</p>

            <button class="wishlist-list-remove" data-id-product={$item->id}>
                {l s='Remove from wishlist' mod='wishlist'}
            </button>
            <hr>
        </div>
    {/foreach}
{/block}
