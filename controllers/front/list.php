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
        $this->display_column_right = false;
        $this->display_column_left = false;
        $context = Context::getContext();
        if (empty($context->customer->id)) {
            Tools::redirect('index.php');
        }

        parent::initContent();

        $this->context->smarty->tpl_vars['page']->value['body_classes']['page-customer-account'] = true;
        $this->setTemplate('module:wishlist/views/templates/front/test.tpl');
    }

}