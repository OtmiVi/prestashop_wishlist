<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class Wishlist extends Module
{

    public function __construct()
    {
        $this->name = 'wishlist';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Yura Kuziv';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' =>  _PS_VERSION_,
            'max' =>  _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Wish List');
        $this->description = $this->l('Wish List module.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('WISHLIST_NAME')) {
            $this->warning = $this->l('No name provided');
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return (
            parent::install()
            && Configuration::updateValue('WISHLIST_NAME', 'wishlist')
            && $this->registerHook('displayProductListReviews')
            && $this->registerHook('actionFrontControllerSetMedia')
            && $this->registerHook('displayProductAdditionalInfo')
        );
    }

    public function uninstall()
    {
        return (
            Configuration::deleteByName('WISHLIST_NAME')
            && parent::uninstall()
        );
    }

    public function hookDisplayProductListReviews()
    {
        return $this->display( __FILE__, 'views/templates/hook/wishlist.tpl');
    }

    public function hookDisplayProductAdditionalInfo()
    {
        return $this->display( __FILE__, 'views/templates/hook/product_page_wishlist.tpl');
    }

    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->registerStylesheet(
            'wishlist-style',
            $this->_path.'views/css/wishlist.css',
            [
                'media' => 'all',
                'priority' => 1000,
            ]
        );

        $this->context->controller->registerJavascript(
            'wishlist-javascript',
            $this->_path.'views/js/wishlist.js',
            [
                'position' => 'bottom',
                'priority' => 1000,
            ]
        );
    }

}