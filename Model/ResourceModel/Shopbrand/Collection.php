<?php
/**
 * Magiccart
 * @category    Magiccart
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/)
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-11 23:15:05
 * @@Modify Date: 2016-02-02 15:52:06
 * @@Function:
 */

namespace Magiccart\Shopbrand\Model\ResourceModel\Shopbrand;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\Store;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magiccart\Shopbrand\Model\Shopbrand', 'Magiccart\Shopbrand\Model\ResourceModel\Shopbrand');
    }

    /**
     * Perform adding filter by store
     *
     * @param int|array|Store $store
     * @param bool $withAdmin
     * @return void
     */
    protected function performAddStoreFilter($store, bool $withAdmin = true)
    {
        if ($store instanceof Store) {
            $store = [$store->getId()];
        }

        if (!is_array($store)) {
            $store = [$store];
        }

        if ($withAdmin) {
            $store[] = Store::DEFAULT_STORE_ID;
        }

        /** @noinspection PhpParamsInspection */
        $this->addFilter('store', ['in' => $store], 'public');
    }

    /**
     * Add filter by store
     *
     * @param int|array|Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, bool $withAdmin = true): Collection
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
            $this->setFlag('store_filter_added', true);
        }

        return $this;
    }
}
