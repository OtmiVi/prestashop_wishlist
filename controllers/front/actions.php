<?php

require_once _PS_MODULE_DIR_ . 'wishlist/classes/WishListEntity.php';

class WishlistActionsModuleFrontController extends ModuleFrontController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function displayAjaxAdd()
    {

        $productId = (int)Tools::getValue('productId');
        $customerId = $this->context->customer->id;

        $wishList = new WishListEntity();
        $wishList->id_customer = $customerId;
        $wishList->id_product = $productId;
        $result = $wishList->save();


        $this->ajaxRender(
            json_encode([
                'success' => $result,
                'message' => [$productId, $customerId],
            ])
        );
        exit;
    }

    public function displayAjaxRemove()
    {

        $productId = (int)Tools::getValue('productId');
        $result = WishListEntity::getProductFromWishlist($productId);

        foreach ($result as $item){
            $wishList = new WishListEntity($item['id_wishlist']);
            $wishList->delete();
        }

        $this->ajaxRender(
            json_encode([
                'success' => $productId,
                'message' => [$productId],
            ])
        );
        exit;
    }

}