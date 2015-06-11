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
 * @package     Tyny_Core
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Locale model
 *
 * @package     Tyny_Core
 * @author Netapsys Team <magento@netapsys.fr>
 */ 
class Tyny_Core_Model_Locale extends Mage_Core_Model_Locale
{
    /**
     * Checks if current date and time of the given store (in the store timezone) is within the range.
     *
     * Works like isStoreDateInInterval() but will not add a day to the $dateTo parameter which
     * caused trouble with special price dates. Also, $dateFrom and $dateTo parameters
     * are supposed to be in UTC. Store date will be converted to UTC for comparison.
     * Keep that in mind if you have to chose between
     * this function and isStoreDateInInterval()
     *
     * @param int|string|Mage_Core_Model_Store $store
     * @param string|null $dateFrom UTC datetime
     * @param string|null $dateTo UTC datetime
     * @return bool
     */
    public function isStoreDatetimeInUtcInterval($store, $dateFrom = null, $dateTo = null)
    {
        if (!$store instanceof Mage_Core_Model_Store) {
            $store = Mage::app()->getStore($store);
        }
        $storeDate = $this->storeDate($store, null, true);
        $utcDate = $this->utcDate($store, $storeDate, true);

        $storeTimeStamp  = strtotime($utcDate->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
        $fromTimeStamp  = strtotime($dateFrom);
        $toTimeStamp    = strtotime($dateTo);

        $result = false;
        if ((!is_empty_date($dateFrom) && $storeTimeStamp < $fromTimeStamp) == false
            && (!is_empty_date($dateTo) && $storeTimeStamp > $toTimeStamp) == false) {
            $result = true;
        }

        return $result;
    }
}