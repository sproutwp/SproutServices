<?php
/**
 * @package Sprout
 * @subpackage SproutServices
 * @since 1.0.0
 */
namespace Sprout\SproutServices;

use Sprout\SproutHelpers\Privileges;

use Sprout\SproutInterfaces\ModuleInterface;

final class SproutServicesInit implements ModuleInterface
{
    /**
     * Unique module name that's used to identify the module throughout the system.
     *
     * @internal Also used to build filter names, an exmaple is a wp_option to decide if this module loads or not.
     *
     * @var string
     */
    private $module_identifier = 'sprout_services';

    /**
     * Handles the main logic of the module itself. This is where you should start the chain of events.
     */
    public function loadModule()
    {
        $this->container = new Container;
        $this->identity_provider = new IdentityProvider;
        $this->parser = new Parser;

        $this->register = new Register( $this->container, $this->identity_provider, $this->parser );

        /**
         * I am literally one-lining this shit because I don't want anyone to see what kind of crap powers Sprout as a whole.
         * Sometimes, you must do what's necessary, even if it isn't the right thing to do. I did what I could, with what I had.
         *
         * Just skip this and don't think about it :)
         */
        add_filter('_sprout_core_services_register', function() {
            return $this->register;
        });

        add_filter('_sprout_core_services_provider', function() {
            return new Provider($this->container);
        });
    }

    /**
     * Retrieves the Sprout Module's name.
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->module_identifier;
    }

    /**
     * Retrieves the action name on which this module should be initialized on.
     *
     * @return string
     */
    public function getStartingAction()
    {
        return 'init';
    }

    /**
     * Retrieves the priority of the module.
     *
     * @internal This is used when loading the module (which always fires on an action).
     *
     * @return int
     */
    public function getPriority()
    {
        return 10;
    }

    /**
     * Function that handles loading of the module's logic. Used as a high-level approach to determine whether the module should
     * load at all.
     *
     * @internal This doesn't handle error checking for the module's inner processes.
     *
     * @return boolean True if the module should load, false if not.
     */
    public function shouldItLoad()
    {
        return True;
    }
}