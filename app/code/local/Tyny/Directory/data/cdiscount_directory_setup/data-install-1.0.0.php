<?php

/** Sets Vietnameses provinces required for the country **/
$statesRequired = Mage::getStoreConfig('general/region/state_required');
Mage::app()->getConfig()->saveConfig('general/region/state_required', $statesRequired . ',VN');