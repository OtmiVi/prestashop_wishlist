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

        $id_product = (int)Tools::getValue('id_product');
        $id_product_attribute = (int)Tools::getValue('id_product_attribute');
        $customerId = $this->context->customer->id;

        $wishList = new WishListEntity();
        $wishList->id_customer = $customerId;
        $wishList->id_product = $id_product;
        $wishList->id_product_attribute = $id_product_attribute;
        $result = $wishList->save();


        $this->ajaxRender(
            json_encode([
                'success' => $result,
            ])
        );
        exit;
    }

    public function displayAjaxRemove()
    {
        $id_customer = $this->context->customer->id;
        $id_product = (int)Tools::getValue('id_product');
        $id_product_attribute = (int)Tools::getValue('id_product_attribute');
        $item = WishListEntity::getProductFromWishlist($id_customer, $id_product, $id_product_attribute);

        $wishList = new WishListEntity($item['id_wishlist']);
        $result = $wishList->delete();


        $this->ajaxRender(
            json_encode([
                'success' => $result,
            ])
        );
        exit;
    }

}