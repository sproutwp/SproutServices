<?php
/**
 * @package Sprout
 * @subpackage SproutServices
 * @since 1.0.0
 */
namespace Sprout\SproutServices;

use Sprout\SproutServices\Interfaces\ContainerInterface;

/**
 * Class that handles the storage of services.
 *
 * @internal Do note that a service is an array in which an object is. The developer will use the wrappers to add services where usually only a handle and the object is passed, but much more is going on.
 *
 * @see Sprout\SproutServices\Register.php for more information as to what is stored to this container and the operations performed.
 */
class Container implements ContainerInterface
{
    /**
     * Holds the services.
     *
     * @var array
     */
    private $services = [];

    /**
     * Adds a service to the collection.
     *
     * @param array $service_package A service as a package (array).
     *
     * @return void
     */
    public function addService( $service_package )
    {
        $this->services[$service_package['handle']] = $service_package;
    }

    /**
     * Retrieves all services.
     *
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }
}