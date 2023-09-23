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
        foreach ($ids as $id){
            $products[] = new Product($id,false, $id_lang);
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