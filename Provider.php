<?php
/**
 * @package Sprout
 * @subpackage SproutServices
 * @since 1.0.0
 */
namespace Sprout\SproutServices;

use Sprout\SproutServices\Interfaces\ContainerInterface;
use Sprout\SproutServices\Interfaces\IdentifierInterface;

/**
 * Class that handles the retrieval of services from the container.
 */
class Provider
{
    /**
     * The container ContainerInterface object where all services are kept.
     *
     * @var array
     */
    private $container;

    public function __construct( ContainerInterface $container )
    {
        $this->container = $container;
    }

    /**
     * Retrieves a service array based on the handle.
     *
     * @param string $handle The unique name / handle for the service.
     * @return array
     */
    public function getService( $handle )
    {
        $services = $this->container->getServices();

        if( isset( $handle, $services ) ) {
            return $services[$handle];
        }

        return new \WP_Error(
            'no-such-service',
            sprintf(
                esc_html__( 'There is no service registered with the handle %s', 'sprout' ),
                $handle
            )
        );
    }

    /**
     * Retrieves all services registered.
     *
     * @return array
     */
    public function getAllServices()
    {
        return $this->container->getServices();
    }
}