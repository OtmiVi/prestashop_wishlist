<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_ . 'wishlist/classes/WishListEntity.php';

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
            'min' => _PS_VERSION_,
            'max' => _PS_VERSION_,
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
            && $this->registerHook('displayNav2')
            && $this->registerHook('displayCustomerAccount')
            && Db::getInstance()->execute(
                'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'wishlist` 
                (
                    `id_wishlist` int(10) NOT NULL AUTO_INCREMENT,
                  `id_product` int(10) NOT NULL,
                  `id_customer` int(10) NOT NULL,
                  PRIMARY KEY (`id_wishlist`)
                ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;')
        );
    }

    public function uninstall()
    {
        return (
            Configuration::deleteByName('WISHLIST_NAME')
            && Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'wishlist`')
            && parent::uninstall()
        );
    }

    public function hookDisplayProductListReviews($params)
    {
        $id_product = $params['product']->id;

        $product = WishListEntity::getProductFromWishlist($id_product);
        dump($product);

        if ($product) {
            $className = 'wishlist-button-remove';
        }else {
            $className = 'wishlist-button';
        }

        $this->context->smarty->assign([
            'class_name' => $className,
        ]);
        return $this->display(__FILE__, 'views/templates/hook/wishlist.tpl');
    }

    public function hookDisplayProductAdditionalInfo()
    {
        return $this->display(__FILE__, 'views/templates/hook/product_page_wishlist.tpl');
    }

    public function hookDisplayNav2()
    {
        $url = Context::getContext()->link->getModuleLink($this->name, 'list', [], true);

        $this->context->smarty->assign([
            'front_controller' => $url,
        ]);

        return $this->display(__FILE__, 'views/templates/hook/list_button.tpl');
    }

    public function hookDisplayCustomerAccount()
    {
        $url = Context::getContext()->link->getModuleLink($this->name, 'list', [], true);

        $this->context->smarty->assign([
            'front_controller' => $url,
        ]);

        return $this->fetch('module:' . $this->name . '/views/templates/front/customerAccount.tpl');
    }

    public function hookActionFrontControllerSetMedia()
    {

        Media::addJsDef( [
                'url' => Context::getContext()->link->getModuleLink($this->name, 'actions', [], true)
            ]
        );
        $this->context->controller->registerStylesheet(
            'wishlist-style',
            $this->_path . 'views/css/wishlist.css',
            [
                'media' => 'all',
                'priority' => 1000,
            ]
        );

        $this->context->controller->registerJavascript(
            'wishlist-javascript',
            $this->_path . 'views/js/wishlist.js',
            [
                'position' => 'bottom',
                'priority' => 1000,
            ]
        );
    }

}