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
 * District
 *
 * @category    Tyny
 * @package     Tyny_Directory
 * @author      Netapsys Team <magento@netapsys.fr>
 */
class Tyny_Directory_Model_District extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('directory/district');
    }

    /**
     * Retrieve district name
     *
     * If name is no declared, then default_name is used
     *
     * @return string
     * @authir AGU
     */
    public function getName()
    {
        $name = $this->getData('name');
        if (is_null($name)) {
            $name = $this->getData('default_name');
        }
        return $name;
    }

    /**
     * Load District by code
     * 
     * @param string $code
     * @param string $regionCode
     * @return Tyny_Directory_Model_District
     * @author AGU
     */
    public function loadByCode($code, $regionCode)
    {
        if ($code) {
            $this->_getResource()->loadByCode($this, $code, $regionCode);
        }
        return $this;
    }

    /**
     * Load district by name 
     * 
     * @param string $name
     * @param string $regionCode
     * @return Tyny_Directory_Model_District
     */
    public function loadByName($name, $regionCode)
    {
        $this->_getResource()->loadByName($this, $name, $regionCode);
        return $this;
    }

}
