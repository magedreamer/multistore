<?php
define('MAGENTO', realpath(dirname(__FILE__)));
require_once MAGENTO . '/app/Mage.php';
Mage::app();

///echo Mage::helper('directory')->getDistrictJson();
$statesRequired = Mage::getStoreConfig('general/region/state_required');
Mage::app()->getConfig()->saveConfig('general/region/state_required', $statesRequired . ',VN');