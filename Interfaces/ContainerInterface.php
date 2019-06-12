<?php
/**
 * @package Sprout
 * @subpackage SproutServices\Interfaces
 * @since 1.0.0
 */
namespace Sprout\SproutServices\Interfaces;

/**
 * Interface that decides the methods that each Container object needs to implement.
 */
interface ContainerInterface
{
    /**
     * Adds a service to the services pool.
     *
     * @param array $service_package A service as array.
     */
    public function addService( $service_package );

    /**
     * Retrieves all currently registered services.
     *
     * @return array
     */
    public function getServices();
}