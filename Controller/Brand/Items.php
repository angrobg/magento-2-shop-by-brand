<?php

namespace Magiccart\Shopbrand\Controller\Brand;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\View\LayoutFactory;

class Items extends Action
{
    /**
     * @var RawFactory
     */
    protected RawFactory $resultRawFactory;

    /**
     * @var LayoutFactory
     */
    protected LayoutFactory $layoutFactory;

    /**
     * @param Context $context
     * @param RawFactory $resultRawFactory
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        Context       $context,
        RawFactory    $resultRawFactory,
        LayoutFactory $layoutFactory
    )
    {
        parent::__construct($context);

        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
    }

    public function execute()
    {
        $resultRaw = $this->resultRawFactory->create();

        // Create layout and get the block
        $layout = $this->layoutFactory->create();
        // do not cache - items are randomized
        $block = $layout->createBlock(\Magiccart\Shopbrand\Block\Brand\Slider\Items::class, 'brand_items', [
            'data' => [
                'random_items' => true,
            ],
        ])
            ->setTemplate('Magiccart_Shopbrand::brand/slider/items.phtml');

        $html = $block->toHtml();

        return $resultRaw->setContents($html);
    }
}
