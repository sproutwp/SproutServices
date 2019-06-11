<?php
/**
 * @package Sprout
 * @subpackage Sprout/SproutServices\Interfaces
 * @since 1.0.0
 */
namespace SproutServices\Interfaces;

/**
 * Interface that decides the methods that each IdentityProvider object needs to implement.
 */
interface IdentityProviderInterface
{
    /**
     * Builds the identity of an object, in short, whatever you decide you want to store about an object,
     * the IdentityProvider will do, on each registration of a new service.
     *
     * @param object $object Clearly an interface.
     */
    public function buildServiceIdentity( $object );
}