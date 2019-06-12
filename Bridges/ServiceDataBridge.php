<?php
/**
 * @package Sprout
 * @subpackage Sprout/SproutServices\Bridges
 * @since 1.0.0
 */
namespace SproutServices\Bridges;


use SproutCache\Graph\Wrappers\SproutCacheGraphWrappers as GraphWrappers;
use SproutCache\Graph\Helpers\CacheGraphHelpers as GraphHelpers;

final class ServiceDataBridge
{
    public static function createServiceToDataBridge( $flag, $transient_as_data_name, $module_for_data, $transient_as_data )
    {
        /**
         * Adds our transient to the tracking system and lets it know that it should delete
         * it (the transient) when the action $flag happens.
         */
        GraphWrappers::addTransientForTracking(
            $transient_as_data_name,
            $module_for_data,
            $flag
        );

        /**
         * @internal Please use GraphHelpers::getTransient whenever working with Sprout-related transients
         * or make sure that your transient has no expiry date because otherwise you will delete the transient
         * when the time is over and although the system knows how to deal with this situation, if you've deleted
         * a transient, but have not hit the action that's supposed to clear it, problems could occur.
         */
        GraphHelpers::setTransient( $transient_as_data_name, $transient_as_data );
    }
}