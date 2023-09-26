<?php
function upgrade_module_1_1_6($module)
{

    $sql = [];
    $sql[] = "ALTER TABLE `" . _DB_PREFIX_ . "wishlist`
             ADD `id_product_attribute` int(10);";

    foreach ($sql as $query) {
        if (Db::getInstance()->execute($query) === false) {
            return Db::getInstance()->getMsgError();
        }
    }

    return true;
}