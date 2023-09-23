<?php

require_once _PS_MODULE_DIR_ . 'wishlist/classes/WishListEntity.php';

class WishlistListModuleFrontController extends ModuleFrontController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function initContent()
    {
        $context = Context::getContext();
        $customerId = $context->customer->id;
        if (empty($customerId)) {
            Tools::redirect('index.php');
        }

        $id_lang = $this->context->language->id;
        $ids = WishListEntity::getProductIdsList();
        $products = [];
        foreach ($ids as $id){
            $product = new Product($id,false, $id_lang);
            $product->price_static = Product::getPriceStatic($id,null,null,0);
            $images = Image::getImages($id_lang, $id);
            $image = new Image($images[0]['id_image']);
            $image_url = _PS_BASE_URL_._THEME_PROD_DIR_.$image->getExistingImgPath() . '.jpg';
            $product->image = $image;
            $product->image_url = $image_url;
            $products[] = $product;
        }

        parent::initContent();
        dump($products[0]);

        $this->context->smarty->assign([
            'data' => $products,
        ]);
        $this->setTemplate('module:wishlist/views/templates/front/list.tpl');
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
        $breadcrumb['links'][] = [
            'title' => $this->l('Wish List', [], 'wishlist'),
            'url' => $this->context->link->getModuleLink($this->module->name, 'list', [], true),
        ];

        return $breadcrumb;
    }

}