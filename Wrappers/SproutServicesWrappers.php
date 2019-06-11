<?php
/**
 * @package Sprout
 * @subpackage Sprout/SproutServices/Wrappers
 * @since 1.0.0
 */
namespace SproutServices\Wrappers;

use SproutHelpers\Privileges;

/**
 * A collection of wrapper, final functions that any developer willing to use the SproutServices module
 * can easily use without having to worry about the inner-workings of the system.
 *
 * @internal Available after the init hook, on priority 10.
 */
final class SproutServicesWrappers
{
    /**
     * Registers a service.
     *
     * @param string $handle The unique handler to the service.
     * @param object $object The object we're passing to be wrapped under a service.
     * @return True|WP_Error Returns true if all went well and a WP_Error if there was an error (most likely you are calling this function too early).
     *
     * @see Sprout/SproutServices/Register->registerService() to understand the default behavior of when a WP_Error will be thrown during the register process.
     */
    public static function registerService( $handle, $object, $permission_callback = null )
    {
        $register = apply_filters( '_sprout_core_services_register', null );

        if( is_null( $register ) ) {
            return new \WP_Error(
                'no-register',
                esc_html__( 'No register was provided, you are most likely running this way too early. The services wrappers are available after the init hook, 10 priority.', 'sprout' )
            );
        }

        switch ( $permission_callback ) {
            case 'user_logged_in':
                $permission_callback = function() {
                    if( is_user_logged_in() ) {
                        return True;
                    }
                    return False;
                };
                break;
            case 'can_load_sprout':
                $permission_callback = function() {
                    if( Privileges::canLoadSprout() ) {
                        return True;
                    }
                    return False;
                };
                break;
            case null:
                $permission_callback = function() {
                    return True;
                };
        }

        $registration = $register->registerService( $handle, $object, $permission_callback );

        if( !$registration ) {
            return False;
        } elseif( is_wp_error( $registration ) ) {
            return $registration;
        }

        return True;
    }

    /**
     * Retrieves a service from the container
     *
     * @param string $handle The unique handle used to search for the service in the container.
     *
     * @return Array|WP_Error Returns an array (the service) if successfully found or a WP_Error on error.
     */
    public static function getService( $handle )
    {
        $provider = apply_filters( '_sprout_core_services_provider', null );

        if( is_null( $provider ) ) {
            return new \WP_Error(
                'no-provider',
                esc_html__( 'No provider registered, you are most likely running this way too early. The services wrappers are available after the init hook, 10 priority.', 'sprout' )
            );
        } else {
            $service = $provider->getService( $handle );

            if( is_wp_error( $service ) || !$service ) {
                return $service;
            }

            if( !$service['permission_callback']() ) {
                return new \WP_Error(
                    'no-permissions',
                    esc_html__( 'You do not have the right permissions to access this service.', 'sprout' )
                );
            }

            return $provider->getService( $handle );
        }
    }

    /**
     * Retrieves the object of a service.
     *
     * @param string $handle The unique handle used to search for the service in the container.
     *
     * @return Array|WP_Error Returns an array (the service) if successfully found or a WP_Error on error.
     */
    public static function getServiceObject( $handle )
    {
        $provider = apply_filters( '_sprout_core_services_provider', null );

        if( is_null( $provider ) ) {
            return new \WP_Error(
                'no-provider',
                esc_html__( 'No provider registered, you are most likely running this way too early. The services wrappers are available after the init hook, 10 priority.' )
            );
        } else {
            $service = self::getService( $handle );

            if( !$service ) {
                return new \WP_Error(
                    'no-service',
                    esc_html__( 'The service was not found.' )
                );
            }

            if( is_wp_error( $service ) ) {
                return $service;
            }

            return $service['object'];
        }
    }

    /**
     * Retrieves all registered services.
     *
     * @return Array|WP_Error Returns an array of all services registered if successful and if not, returns a WP_Error.
     */
    public static function getAllServices()
    {
        $provider = apply_filters( '_sprout_core_services_provider', null );

        if( is_null( $provider ) ) {
            return new \WP_Error(
                'no-provider',
                esc_html__( 'No provider registered, you are most likely running this way too early. The services wrappers are available after the init hook, 10 priority.' )
            );
        } else {
            return $provider->getAllServices();
        }
    }
}