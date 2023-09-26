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
        $this->version = '1.1.6';
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
            && $this->registerHook('displayShoppingCartFooter')
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

        $customerId = Context::getContext()->customer->id;
        if (!empty($customerId)) {
            $id_product = $params['product']->id;

            $product = WishListEntity::getProductFromWishlist($id_product);

            if ($product) {
                $className = 'wishlist-button-remove';
            }else {
                $className = 'wishlist-button';
            }

            $this->context->smarty->assign([
                'class_name' => $className,
            ]);
        } else {
            $this->context->smarty->assign([
                'class_name' => 'wishlist-button',
            ]);
        }

        Media::addJsDef( [
                'add_button' => $this->l('Add to wishlist', 'wishlist'),
                'remove_button' => $this->l('Remove from wishlist', 'wishlist')
            ]
        );

        return $this->display(__FILE__, 'views/templates/hook/wishlistAddButton.tpl');
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
    public function hookDisplayShoppingCartFooter()
    {

        $context =  Context::getContext();

        $id_lang = $this->context->language->id;
        $ids = WishListEntity::getProductIdsList();
        $products = [];
        foreach ($ids as $id){
            $product = new Product($id,false, $id_lang);
            $product->price_static = Product::getPriceStatic($id,null,null,2);
            $images = Image::getImages($id_lang, $id);
            $image = new Image($images[0]['id_image']);
            $image_url = _PS_BASE_URL_._THEME_PROD_DIR_.$image->getExistingImgPath() . '.jpg';
            $product->image = $image;
            $product->image_url = $image_url;
            $products[] = $product;
        }

        $this->context->smarty->assign([
            'data' => $products,
        ]);
        return $this->display(__FILE__, 'views/templates/hook/cart_wishlist.tpl');
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