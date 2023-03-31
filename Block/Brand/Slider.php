<?php
/**
 * Magiccart
 * @Author: Martin Kovachev <miracle@nimasystems.com>
 */

// NIMA CHANGES

namespace Magiccart\Shopbrand\Block\Brand;

use Magento\Catalog\Block\Product\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Serialize\Serializer\Json as SerializerJson;
use Magento\Framework\View\Element\Template;
use Magento\Review\Model\Review;
use Magiccart\Shopbrand\Helper\Data;
use Magiccart\Shopbrand\Model\ResourceModel\Shopbrand\Collection;
use Magiccart\Shopbrand\Model\ShopbrandFactory;

class Slider extends Template
{
    const CACHE_TAGS = 'MAGICCART_SHOPBYBRAND_BRAND_SLIDER';
    protected $_resource;
    protected $_storeManager;
    protected $_scopeConfig;
    protected $_storeCode;
    protected $_review;
    protected $_objectManager;

    /**
     * @var ShopbrandFactory
     */
    protected ShopbrandFactory $_shopbrandFactory;

    /**
     * @var ?Collection
     */
    protected ?Collection $_brandCollection = null;

    /**
     * @var Data
     */
    protected Data $_helper;

    /**
     * @var SerializerJson
     */
    private SerializerJson $jsonSerializer;


    public function __construct(
        ObjectManagerInterface $objectManager,
        ResourceConnection     $resource,
        Review                 $review,
        Context                $context,
        SerializerJson         $jsonSerializer,
        ShopbrandFactory       $shopbrandFactory,
        Data                   $helper,
        array                  $data = [],
                               $attr = null
    )
    {
        $this->_objectManager = $objectManager;
        $this->_resource = $resource;
        $this->_storeManager = $context->getStoreManager();
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_storeCode = $this->_storeManager->getStore()->getCode();
        $this->jsonSerializer = $jsonSerializer;
        $this->_shopbrandFactory = $shopbrandFactory;
        $this->_helper = $helper;
        $this->_review = $review;

        parent::__construct($context, $data);
    }

    protected bool $useCache = true;

    /**
     * @return Data
     */
    public function getHelper(): Data
    {
        return $this->_helper;
    }

    /**
     * Resource initialization
     */
    protected function _construct()
    {
        parent::_construct();

        if ($this->useCache) {
            $this->addData(
                [
                    'cache_lifetime' => 86400,
                    'cache_tags' => [self::CACHE_TAGS,],
                ]
            );
        }
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    public function getCacheKeyInfo(): array
    {
        if (!$this->useCache) {
            return [];
        }

        $params = $this->getRequest()->getParams();
        return [
            'BLOCK_TPL_MAGGICCART_SHOPBYBRAND_BLOCK_BRAND_SLIDER',
            $this->_storeManager->getStore()->getCode(),
            $this->_storeManager->getStore()->getId(),
            $this->_storeManager->getStore()->getCurrentCurrencyCode(),
            'magiccart_shopbybrand_block_brand_slider_layout',
            $this->getTemplateFile(),
            'base_url' => $this->getBaseUrl(),
            'template' => $this->getTemplate(),
            $this->jsonSerializer->serialize($params),
        ];
    }

    protected function getBrandCollection()
    {
        if (!$this->_brandCollection) {
            $store = $this->_storeManager->getStore()->getStoreId();
            $collection = $this->_shopbrandFactory->create()->getCollection()
                ->addFieldToFilter('stores', [['finset' => 0], ['finset' => $store]])
                ->addFieldToFilter('status', 1);
            $this->_brandCollection = $collection;
        }
        return $this->_brandCollection;
    }

    public function getBrands()
    {
        $collection = $this->getBrandCollection();
        $collection->addFieldToFilter('visible_on_home_page', ['eq' => '1']);
        $collection->setOrder('title', 'ASC');
        return $collection;
    }

    protected function _toHtml()
    {
        $template_file = $this->getTemplate();
        $template_file = (!empty($template_file)) ? $template_file : "Magiccart_Shopbrand::brand/slider.phtml";

        $this->setTemplate($template_file);
        return parent::_toHtml();
    }
}
