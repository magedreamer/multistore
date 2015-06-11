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
 * Directory data helper
 *
 * @author Netapsys Team <magento@netapsys.fr>
 */
class Tyny_Directory_Helper_Data extends Mage_Directory_Helper_Data
{
    /*
     * Path to config value, which lists available regions
     */
    const XML_PATH_AVAILABLE_REGIONS = 'general/vietnamese_province_district/allow_region';
    
    /*
     * Path to config value, which lists available districts
     */
    const XML_PATH_AVAILABLE_DISTRICTS = 'general/vietnamese_province_district/allow_district';

    /**
     * Json representation of districts data
     *
     * @var string
     */
    protected $_districtJson;
    
    /**
     * Returns flag, which indicates whether region is available
     *
     * @param string $regionId
     * @return bool
     */
    public function isRegionAvailable($regionId)
    {
        $availableRegions = explode(',', Mage::getStoreConfig(self::XML_PATH_AVAILABLE_REGIONS));
        if(!is_array($availableRegions)) {
            return false;
        }
        return in_array($regionId, $availableRegions);
    }
        
    /**
     * Returns flag, which indicates whether district is available
     *
     * @param string $districtId
     * @return bool
     */
    public function isDistrictAvailable($districtId)
    {
        $availableDistricts = explode(',', Mage::getStoreConfig(self::XML_PATH_AVAILABLE_DISTRICTS));
        if(!is_array($availableDistricts)) {
            return false;
        }
        return in_array($districtId, $availableDistricts);
    }

    /**
     * Retrieve regions data json with region availability check
     *
     * @return string
     */
    public function getRegionJson()
    {
        Varien_Profiler::start('TEST: '.__METHOD__);
        if (!$this->_regionJson) {
            $cacheKey = 'DIRECTORY_REGIONS_JSON_STORE'.Mage::app()->getStore()->getId();
            if (Mage::app()->useCache('config')) {
                $json = Mage::app()->loadCache($cacheKey);
            }
            if (empty($json)) {
                $countryIds = array();
                foreach ($this->getCountryCollection() as $country) {
                    $countryIds[] = $country->getCountryId();
                }
                $collection = Mage::getModel('directory/region')->getResourceCollection()
                    ->addCountryFilter($countryIds)
                    ->load();
                $regions = array(
                    'config' => array(
                        'show_all_regions' => $this->getShowNonRequiredState(),
                        'regions_required' => $this->getCountriesWithStatesRequired()
                    )
                );
                foreach ($collection as $region) {
                    if (!$region->getRegionId()) {
                        continue;
                    }
                    if (!$this->isRegionAvailable($region->getRegionId())) {
                        continue;
                    }
                    $regions[$region->getCountryId()][$region->getRegionId()] = array(
                        'code' => $region->getCode(),
                        'name' => $this->__($region->getName())
                    );
                }
                $json = Mage::helper('core')->jsonEncode($regions);

                if (Mage::app()->useCache('config')) {
                    Mage::app()->saveCache($json, $cacheKey, array('config'));
                }
            }
            $this->_regionJson = $json;
        }

        Varien_Profiler::stop('TEST: '.__METHOD__);
        return $this->_regionJson;
    }

    /**
     * Retrieve districts data json
     *
     * @return string
     */
    public function getDistrictJson()
    {
        Varien_Profiler::start('TEST: '.__METHOD__);
        if (!$this->_districtJson) {
            $cacheKey = 'DIRECTORY_DISTRICTS_JSON_STORE'.Mage::app()->getStore()->getId();
            if (Mage::app()->useCache('config')) {
                $json = Mage::app()->loadCache($cacheKey);
            }
            if (empty($json)) {
                $regions = Mage::getResourceModel('directory/region_collection')
                    ->setOrder('code', Varien_Data_Collection::SORT_ORDER_ASC)
                    ->addCountryFilter('VN');
                $districts = array();
                foreach ($regions as $region) {
                    if (!$this->isRegionAvailable($region->getId())) {
                        continue;
                    }
                    $regionDistricts = Mage::getResourceModel('directory/district_collection')
                        ->addRegionFilter($region->getCode());
                    foreach ($regionDistricts as $district) {
                        if (!$this->isDistrictAvailable($district->getId())) {
                            continue;
                        }
                        $districts[$region->getId()][$district->getId()] = array(
                            'id' => $district->getId(),
                            'name' => $this->__($district->getName())
                        );
                    }
                }
                $json = Mage::helper('core')->jsonEncode($districts);
                if (Mage::app()->useCache('config')) {
                    Mage::app()->saveCache($json, $cacheKey, array('config'));
                }
            }
            $this->_districtJson = $json;
        }
        Varien_Profiler::stop('TEST: '.__METHOD__);
        return $this->_districtJson;
    }
}
