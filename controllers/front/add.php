<?php

class WishlistAddModuleFrontController extends ModuleFrontController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function postProcess()
    {
        if (false === $this->context->customer->isLogged()) {
            $this->ajaxRender(
                json_encode([
                    'success' => false,
                    'message' => 0,
                ])
            );
            exit;
        }

        $methodName = Tools::getValue('action') . 'Action';


        if (method_exists($this, $methodName)) {
            call_user_func([$this, $methodName], Tools::getAllValues());
        }

        $this->ajaxRender(
            json_encode([
                'success' => false,
                'message' => 'ection not found',
            ])
        );
        exit;
    }

    public function addAction($params)
    {

        $productId = (int)$params['productId'];
        $customerId = $this->context->customer->id;
        $this->ajaxRender(
            json_encode([
                'success' => false,
                'message' => [1,2],
            ])
        );
        exit;
    }

}