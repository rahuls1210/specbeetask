<?php
namespace Drupal\adminconfigform\Plugin\Block;
use Drupal\Component\Datetime;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\adminconfigform\TimeZoneServices;
use Drupal\Core\Cache\Cache;


/**
 * Provides a 'Timezone' Block.
 *
 * @Block(
 *   id = "timezone_block",
 *   admin_label = @Translation("Timezone block"),
 *   category = @Translation("Timezone"),
 * )
 */
class TimezoneBlock extends BlockBase implements ContainerFactoryPluginInterface {
	/**
   * @var AccountInterface $account
   */
  protected $timezone;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\adminconfigform\TimeZoneServices $timezone
   */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, TimeZoneServices $timezone) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->timezone = $timezone;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('adminconfigform.timezone_service')
    );
  }

  /**
   * {@inheritdoc}
	 *  
   */
  public function build() {
		
		$date = $this->timezone->getTimzonesetting();
		$country = $this->timezone->getCountry();
		$city = $this->timezone->getCity();

    return [
    	'#theme' => 'adminconfigform',
			'#country' => $country,
			'#city' => $city,
			'#timezone' => $date
    ];
  }
	
	/**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $node = \Drupal::routeMatch()->getParameter('node');
    return Cache::mergeTags(parent::getCacheTags(), ['config:'.$timezone]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return Cache::PERMANENT;
  }
  /* public function getCacheContexts() {
    return Cache::mergeContexts(
      parent::getCacheContexts(),
      ['timezone']
    );
  }*/
}