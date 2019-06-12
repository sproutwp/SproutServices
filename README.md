# Sprout Services
_The module, by default, loads on the `init` hook with a priority of `10`, if you launch it too early, it will not be compatible with other Sprout Modules._

A services container &amp; provider used by the Sprout Framework

### How to load
If you're inside Sprout, it'll handle it for you! If you're using it as a standalone package, you must initialize `SproutServices\SproutServicesInit` and call `loadModule`.

### How to use

Register your object as a service:
```
SproutServices\Wrappers\SproutServicesWrappers::registerService( 'myService', new TestService );
```
Retrieve it:
```
SproutServices\Wrappers\SproutServicesWrappers::getService( 'myService' );
```
Even if it will be spoken about in the documentation, there's a lot of mumbo jumbo in the back-end such as determining service identity to ensure it cannot be overwriten by objects that are not alike, so it is safe (as much as PHP allows without strong return types in interfaces) to use for dependencies, e.g: you'll always get an object that does the same thing, but you must enforce it throught interfaces.
