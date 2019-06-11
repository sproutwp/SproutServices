<?php
/**
 * @package Sprout
 * @subpackage Sprout/SproutServices
 * @since 1.0.0
 */
namespace SproutServices;

use SproutServices\Interfaces\IdentifierInterface;
use SproutServices\Interfaces\ParserInterface;

/**
 * Parser class that deals with checking two objects when the system tries to overwrite a service, as determined
 * by the logic of the Register.
 */
final class Parser implements ParserInterface
{
    /**
     * Checks whether or not two objects implement the same classes, as such, conceptually, they are the same.
     * We do not care of these objects' methods implementation, nor can we known without return types, as such,
     * this is a shallow check.
     *
     * @param mixed $service_package A package of data that is used by the function, in this case, as per the Register's logic, two objects are passed.
     * @internal The $service_package is intentedly left ambiguous, but its contents are determined by what the Register passes. You will need to re-write the Register if you want newly passed values.
     *
     * @return boolean
     */
    public function parseService( $service_package )
    {
        if( class_implements( $service_package[0] ) === class_implements( $service_package[1] ) ) {
            return True;
        }

        return False;
    }

    /**
     * Checks for the handle & the object to be of correct type.
     *
     * @param mixed $handle
     * @param mixed $object
     */
    public function parseHandleAndObject( $handle, $object )
    {
        if( !is_string( $handle ) ) {
            return new \WP_Error(
                'no-valid-handle',
                sprintf(
                    esc_html__( '%s: You provided an item of type %s for the handle when trying to register the service, but it must be a string.', 'sprout' ),
                    (string) $handle,
                    gettype( $handle )
                )
            );
        }

        if( !is_object( $object ) ) {
            return new \WP_Error(
                'no-valid-object',
                sprintf(
                    esc_html__( '%s: You provided an item of type %s for the object when trying to register the service, but it must be an object.', 'sprout' ),
                    (string) $handle,
                    gettype( $object )
                )
            );
        }
    }
}