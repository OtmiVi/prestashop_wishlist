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
        $customerId = $this->context->customer->id;
        if (empty($customerId)) {
            Tools::redirect('index.php');
        }

        $id_lang = $this->context->language->id;
        $list = WishListEntity::getProductIdsList();
        $products = [];
        foreach ($list as $item) {
            $product = new Product($item['id_product'], true, $id_lang);
            $product->price_static = Product::getPriceStatic($item['id_product'], null, $item['id_product_attribute'], 2);
            $images = Image::getImages($id_lang, $item['id_product'], $item['id_product_attribute']);
            $image = new Image($images[0]['id_image']);
            $image_url = _PS_BASE_URL_ . _THEME_PROD_DIR_ . $image->getExistingImgPath() . '.jpg';
            $product->image = $image;
            $product->image_url = $image_url;
            $product->id_product_attribute = $item['id_product_attribute'];
            $products[] = $product;
        }

        parent::initContent();

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