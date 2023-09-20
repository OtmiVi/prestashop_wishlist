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

}