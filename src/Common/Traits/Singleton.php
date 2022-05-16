<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\Common\Traits;

/**
 * The singleton skeleton trait to instantiate the class only once
 *
 * @package DCEventsManager\Common\Traits
 * @since 1.0.0
 */
trait Singleton {
	private static $instance;

	/**
	 * @return self
	 * @since 1.0.0
	 */
	final public static function instantiate(): self {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
