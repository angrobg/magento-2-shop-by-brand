<?php
/**
 * Magiccart
 * @Author: Martin Kovachev <miracle@nimasystems.com>
 */

// NIMA CHANGES
namespace Magiccart\Shopbrand\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '2.0.1', '<=')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('magiccart_shopbrand'),
                'visible_on_home_page',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length' => 1,
                    'nullable' => false,
                    'default' => 0,
                    'comment' => 'Visible on home page',
                ]
            );
        }

        $installer->endSetup();
    }
}
