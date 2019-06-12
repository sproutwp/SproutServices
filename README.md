# Sprout Services
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
