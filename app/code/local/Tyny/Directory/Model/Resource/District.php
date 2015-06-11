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
 * Directory District Resource Model
 *
 * @category    Tyny
 * @package     Tyny_Directory
 * @author      Netapsys Team <magento@netapsys.fr>
 */
class Tyny_Directory_Model_Resource_District extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define district table
     * 
     * @return void
     * @author AGU
     */
    protected function _construct()
    {
        $this->_init('directory/country_region_district', 'district_id');
    }
    
    /**
     * Load object by country id and code or default name
     *
     * @param Mage_Core_Model_Abstract $object
     * @param int $regionCode
     * @param string $value
     * @param string $field
     * 
     * @return Tyny_Directory_Model_Resource_District
     * @author AGU
     */
    protected function _loadByRegion($object, $regionCode, $value, $field)
    {
        $adapter        = $this->_getReadAdapter();
        $select         = $adapter->select()
            ->from(array('district' => $this->getMainTable()))
            ->where('district.region_code = ?', $regionCode)
            ->where("district.{$field} = ?", $value);

        $data = $adapter->fetchRow($select);
        if ($data) {
            $object->setData($data);
        }

        $this->_afterLoad($object);

        return $this;
    }

    /**
     * Loads district by district code and region code
     *
     * @param Mage_Directory_Model_District $district
     * @param string $districtCode
     * @param string $regionCode
     * @return Tyny_Directory_Model_Resource_District
     * @author AGU
     */
    public function loadByCode(Mage_Directory_Model_District $district, $districtCode, $regionCode)
    {
        return $this->_loadByRegion($district, $regionCode, (string)$districtCode, 'code');
    }

    /**
     * Load data by country id and default region name
     *
     * @param Mage_Directory_Model_District $district
     * @param string $districtName
     * @param string $regionCode
     * 
     * @return Tyny_Directory_Model_Resource_District
     */
    public function loadByName(Mage_Directory_Model_District $district, $districtName, $regionCode)
    {
        return $this->_loadByRegion($district, $regionCode, (string)$districtName, 'default_name');
    }
}
