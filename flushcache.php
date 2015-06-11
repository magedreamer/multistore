<?php
define('MAGENTO', realpath(dirname(__FILE__)));
require_once MAGENTO . '/app/Mage.php';
Mage::app();

Mage::app()->getCacheInstance()->flush();
//Enterprise_PageCache_Model_Cache::getCacheInstance()->clean();
  // Enterprise_PageCache_Model_Cache::getCacheInstance()->clean(Enterprise_PageCache_Model_Processor::CACHE_TAG);