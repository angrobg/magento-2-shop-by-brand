<?php

namespace Magiccart\Shopbrand\Controller\Brand;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

class View implements HttpGetActionInterface
{
    private PageFactory $pageFactory;

    public function __construct(
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
    }

    public function execute(): Page
    {
        return $this->pageFactory->create();
    }
}
