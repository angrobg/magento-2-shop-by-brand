<?php
/**
 * Magiccart
 * @Author: Martin Kovachev <miracle@nimasystems.com>
 */

// NIMA CHANGES

namespace Magiccart\Shopbrand\Block\Brand;

use Magento\Catalog\Block\Product\Context;
use Magento\Framework\View\Element\Template;
use Magiccart\Shopbrand\Helper\Data;

class Slider extends Template
{
    /**
     * @var Data
     */
    protected Data $_helper;

    /**
     * @var bool
     */
    protected bool $loadedOnVisible = false;

    /**
     * @return bool
     */
    public function isLoadedOnVisible(): bool
    {
        return $this->loadedOnVisible;
    }

    /**
     * @param Context $context
     * @param Data $helper
     * @param array $data
     * @param null $attr
     */
    public function __construct(
        Context $context,
        Data    $helper,
        array   $data = [],
                $attr = null
    )
    {
        $this->_helper = $helper;

        parent::__construct($context, $data);
    }

    /**
     * Resource initialization
     */
    protected function _construct()
    {
        parent::_construct();

        $this->loadedOnVisible = (bool)$this->getData('loaded_on_visible');
    }

    public function getBrandItemsUrl(): string
    {
        return $this->getUrl('shopbrand/brand/items');
    }

    protected function _toHtml(): string
    {
        $template_file = $this->getTemplate();
        $template_file = (!empty($template_file)) ? $template_file : "Magiccart_Shopbrand::brand/slider.phtml";

        $this->setTemplate($template_file);
        return parent::_toHtml();
    }
}
