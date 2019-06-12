<?php
/**
 * @package Sprout
 * @subpackage SproutServices
 * @since 1.0.0
 */
namespace Sprout\SproutServices;

use Sprout\SproutServices\Interfaces\ContainerInterface;
use Sprout\SproutServices\Interfaces\IdentityProviderInterface;
use Sprout\SproutServices\Interfaces\ParserInterface;

/**
 * Class that handles the registration of services to the container.
 */
class Register
{
    /**
     * The ContainerInterface container object. Services are stored here.
     *
     * @var object
     */
    private $container;

    /**
     * The IdentityProviderInterface identity provider object, it creates an identity with desired
     * information for each service that will then be saved alongside the said service in the container.
     *
     * @var object
     */
    private $identity_provider;

    /**
     * The ParserInterface parser object that deals with checks when an object is trying to over-write
     * another in the container. This parser decides whether the new object should overwrite the old
     * one based on defined logic.
     *
     * @internal The default behavior of the Parser is that of checking if two classes implement the same interfaces (as such they're conceptually the same) and if they do, allow overwriting.
     *
     * @var object
     */
    private $parser;

    public function __construct( ContainerInterface $container, IdentityProviderInterface $identity_provider, ParserInterface $parser )
    {
        $this->container = $container;
        $this->identity_provider = $identity_provider;
        $this->parser = $parser;
    }

    /**
     * Registers / saves a service to the container.
     *
     * @param string $handle The unique handle that will be used to store the service and identify it.
     * @param object $object The object we're trying to register.
     * @param callable $permission_callback The permission callback that is called every time the object is called.
     *
     * @return boolean Returns True if all went well, regardless of overwrite or not and returns false if not.
     */
    public function registerService( $handle, $object, $permission_callback )
    {
        $services = $this->getServicesFromContainer();

        $object_and_handle_check = $this->parser->parseHandleAndObject( $handle, $object );

        if( is_wp_error( $object_and_handle_check ) ) {
            return $object_and_handle_check;
        }

         //If we found a service package that matches the current handle that's trying to register.
        if( array_key_exists( $handle, $services ) ) {
            //Check if they implement the same interfaces, as in, if they are the same conceptually
            if( $this->parser->parseService( [$services[$handle]['object'], $object] ) ) {
                //And if so, perform an overwrite.
                $this->container->addService([
                    'handle' => $handle,
                    'object' => $object,
                    'permission_callback' => $permission_callback,
                    'identity' => $this->identity_provider->buildServiceIdentity( $object )
                ]);
                return True;
            } else {
                //Otherwise, reject it because even if we'd like to overwrite, we can never overwrite a service's object with a new object that doesn't do the same thing.
                return new \WP_Error(
                    'services-objects-do-not-match',
                    sprintf(
                        esc_html__( 'The service with the handle %s exists, but you tried overwriting this service with an object that does not respect the same interfaces as the old one. Make sure the new object you are trying to overwrite with respects the same interfaces.' ),
                        $handle
                    )
                );
            }
        } else {
            //If we didn't find the handle, it means it's a new service being added. No need for any checks.
            $this->container->addService([
                'handle' => $handle,
                'object' => $object,
                'permission_callback' => $permission_callback,
                'identity' => $this->identity_provider->buildServiceIdentity( $object )
            ]);
        }

        return True;
    }

    /**
     * Retrieves all services from the container.
     *
     * @return array
     */
    private function getServicesFromContainer()
    {
        return $this->container->getServices();
    }
}