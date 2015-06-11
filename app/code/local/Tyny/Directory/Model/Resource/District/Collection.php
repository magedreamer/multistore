<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Tyny
 * @package     Tyny_Directory
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */


/**
 * District collection
 *
 * @category    Tyny
 * @package     Tyny_Directory
 * @author      Netapsys Team <magento@netapsys.fr>
 */
class Tyny_Directory_Model_Resource_District_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Country table name
     *
     * @var string
     */
    protected $_countryTable;

    /**
     * Define main and country tables
     *
     * @return void
     * @author AGU
     */
    protected function _construct()
    {
        $this->_init('directory/district');

        $this->_countryTable    = $this->getTable('directory/country');

        $this->addOrder('code', Varien_Data_Collection::SORT_ORDER_ASC);
    }

    /**
     * Filter by country_id
     *
     * @param string|array $countryId
     * @return Tyny_Directory_Model_Resource_District_Collection
     * @author AGU
     */
    public function addCountryFilter($countryId)
    {
        if (!empty($countryId)) {
            if (is_array($countryId)) {
                $this->addFieldToFilter('main_table.country_id', array('in' => $countryId));
            } else {
                $this->addFieldToFilter('main_table.country_id', $countryId);
            }
        }
        return $this;
    }
    
    /**
     * Filter by region_code
     *
     * @param string|array $regionCode
     * @return Tyny_Directory_Model_Resource_District_Collection
     * @author AGU
     */
    public function addRegionFilter($regionCode)
    {
        if (!empty($regionCode)) {
            if (is_array($regionCode)) {
                $this->addFieldToFilter('main_table.region_code', array('in' => $regionCode));
            } else {
                $this->addFieldToFilter('main_table.region_code', $regionCode);
            }
        }
        return $this;
    }

    /**
     * Filter by district code
     *
     * @param string|array $districtCode
     * @return Tyny_Directory_Model_Resource_District_Collection
     * @author AGU
     */
    public function addDistrictCodeFilter($districtCode)
    {
        if (!empty($districtCode)) {
            if (is_array($districtCode)) {
                $this->addFieldToFilter('main_table.code', array('in' => $districtCode));
            } else {
                $this->addFieldToFilter('main_table.code', $districtCode);
            }
        }
        return $this;
    }

    /**
     * Filter by district name
     *
     * @param string|array $districtName
     * @return Tyny_Directory_Model_Resource_District_Collection
     * @author AGU
     */
    public function addDistrictNameFilter($districtName)
    {
        if (!empty($districtName)) {
            if (is_array($districtName)) {
                $this->addFieldToFilter('main_table.default_name', array('in' => $districtName));
            } else {
                $this->addFieldToFilter('main_table.default_name', $districtName);
            }
        }
        return $this;
    }

    /**
     * Convert collection items to select options array
     *
     * @return array
     * @author AGU
     */
    public function toOptionArray($isMultiselect = false)
    {
        $options = $this->_toOptionArray('district_id', 'default_name', array('title' => 'default_name'));
        if (count($options) > 0 && !$isMultiselect) {
            array_unshift($options, array(
                'title '=> null,
                'value' => '0',
                'label' => Mage::helper('directory')->__('-- Please select --')
            ));
        }
        return $options;
    }
}
