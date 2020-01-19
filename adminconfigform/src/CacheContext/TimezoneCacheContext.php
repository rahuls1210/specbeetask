<?php

namespace Drupal\adminconfigform\CacheContext;

use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\adminconfigform\TimeZoneServices;
use Drupal\Component\Datetime;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheableMetadata;

class TimezoneCacheContext implements CacheContextInterface {
  /**
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
	protected $timezone;

  /**
  * {@inheritdoc}
  */
	public function __construct(TimeZoneServices $timezone) {
   	$this->timezone = $timezone;
	}

  /**
  * {@inheritdoc}
  */
	public static function getLabel() {
		return t('timezone_country');
	}

  /**
  * {@inheritdoc}
  */
	public function getContext() {
    $date = $this->timezone->getTimzonesetting();

    return $date;
	}

  /**
  * {@inheritdoc}
  */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }
}