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
        $customerId = $this->context->customer->id;

        $sql = new DbQuery();
        $sql->select('id_wishlist');
        $sql->from('wishlist', 'w');
        $sql->where('w.id_product = ' . $productId);
        $sql->where('w.id_customer = ' . $customerId);
        $sql = Db::getInstance()->executes($sql);

        foreach ($sql as $item){
            $wishList = new WishListEntity($item['id_wishlist']);
            $wishList->delete();
        }

        $this->ajaxRender(
            json_encode([
                'success' => 1,
                'message' => [1, 1],
            ])
        );
        exit;
    }

}