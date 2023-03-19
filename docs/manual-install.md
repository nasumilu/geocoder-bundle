# Install nasumilu/geocoder-bundle

> It is recommended to utilize the flex recipe, found in the `nasumilu/flex-recipes` repository at
> https://github.com/nasumilu/flex-recipes.


## Install with Composer
```shell
$ cd /my/symfony/application
$ composer required nasumilu/geocoder-bundle
```

By default, if the Symfony application utilizes flex, it will automatically add the bundle to `config/bundles.php`
otherwise add the bundle.

```php
return [
    Nasumilu\GeocoderBundle\NasumiluGeocoderBundle::class => ['all' => true],
];
```

Add the bundle configuration to `config/packages/geocoder.yaml`

```yaml
nasumilu_geocoder:
   # geocoder services - esri, us_census, here
   geocoder: us_census
   # reverse geocoder services - esri & here
   reverse_geocoder: esri
```

Then add the service endpoints (routes) to `config/routes/geocoder.yaml`. See [configure bundle routes](routes.md) for 
more details on the routes provided by this bundle.

```yaml
geocoder:
    resource: '@NasumiluGeocoderBundle/config/routes.xml'
    prefix: services
```

- [Back to nasumilu/geocoder-bundle](../README.md)