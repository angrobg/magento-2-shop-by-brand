<?php

namespace Magiccart\Shopbrand\Controller\Brand;

use Magento\Framework\App\Action\Action;

class View extends Action
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
