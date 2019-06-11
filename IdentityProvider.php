<?php
/**
 * @package Sprout
 * @subpackage Sprout/SproutServices
 * @since 1.0.0
 */
namespace SproutServices;

use SproutServices\Interfaces\IdentityProviderInterface;

/**
 * Class that handles the creation / providing of information and identity about an object.
 */
class IdentityProvider implements IdentityProviderInterface
{
    /**
     * Builds the identity of an object and stores it in its parent service.
     *
     * @param object $object Clearly an interface.
     */
    public function buildServiceIdentity( $object )
    {
        return [
            'interfaces' => class_implements( $object )
        ];
    }
}