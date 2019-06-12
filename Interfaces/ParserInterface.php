<?php
/**
 * @package Sprout
 * @subpackage SproutServices\Interfaces
 * @since 1.0.0
 */
namespace Sprout\SproutServices\Interfaces;

/**
 * Interface that decides the methods that each Parser object needs to implement.
 */
interface ParserInterface
{
    /**
     * Method that employs logic that is, as per default behavior, used to determine whether
     * or not a service's object will be overwriten by the new, provided object.
     *
     * @internal The default checks, as per the default Parser is that the two objects' classes will be compared and if they're the same, overwriting is allowed.
     * @internal Think of this function, when implementing a new Parser, as a way to make sense of what two objects should be identical in and if that's enough for you to over-write a service's object.
     *
     * @param mixed $service_package A service(s) package. As per the default implementation of the Register, it will pass to whatever Parser you provided, in an indexed array, the old object from the service and the new object you're trying to overwrite with.
     * @return boolean Must return True if the overwrite should proceed and False if not.
     */
    public function parseService( $service_package );
}