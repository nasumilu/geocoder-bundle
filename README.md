# Geocoder Bundle

A Symfony bundle which may either be installed as a stand-alone application or into another Symfony applications. 
The bundle provides geocoding and reverse geocoding endpoints backed online service providers.

- [US Census Bureau Geocoding Services](https://geocoding.geo.census.gov/geocoder/Geocoding_Services_API.html)
- [Esri World Geocoder](https://developers.arcgis.com/rest/geocode/api-reference/geocoding-find-address-candidates.htm)
- [HERE.com](https://developer.here.com/)
- More to come, TomTom, TA&M, [PostGIS Geocoder](https://postgis.net/docs/Geocode.html)

> **IMPORTANT** 
> This bundle provides a general interface to easily switch between service providers and is provided as is. It is the 
> *YOUR* responsibility to adhere to chosen service providers terms of user. 

## Geocoder Service(s)

- US Census Bureau
- Esri World Geocoder
- HERE.com

### Reverse Geocoder Service(s)

- Esri World Geocoder
- HERE.com

### Install & Usage

A Symfony Flex recipe is publicly available to easily install this bundle into a new or existing Symfony applications. 

To create a new standalone application (service), first use the [Symfony CLI](https://symfony.com/download) to create 
the application skeleton

```shell
$ cd /home/user/projects
$ symfony new my-geocoder-service

* Creating a new Symfony project with Composer
  (running /usr/bin/composer create-project symfony/skeleton /home/user/projects/my-geocoder-service  --no-interaction)

* Setting up the project under Git version control
  (running git init /home/user/projects/my-geocoder-service)

                                                                                                                        
 [OK] Your project is now ready in /home/user/projects/my-geocoder-service                                            
                                                                                                                       
```

For the newly created app or existing project, add the Symfony Flex recipe to the projects `composer.json` file.

> The `extra.symfony` in the project's `composer.json` will likely exist. As such, just added the `endpoint` key. In
> instance where the application already has other flex-recipe endpoints simply add the `nasumilu/flex-recipes` repo
> index.json at `https://api.github.com/repos/nasumilu/flex-recipes/contents/index.json`.

```json
{
  "extra": {
    "symfony": {
      "endpoint": [
        "https://api.github.com/repos/nasumilu/flex-recipes/contents/index.json",
        "flex://defaults"
      ]
    }
  }
}
```

The bundle may also be installed manually without adding, please see [manual installation](docs/manual-install.md). The 
recommended install method is with the flex recipe and composer.

```shell
$ composer require geocoder
```
Expected output
```shell
Info from https://repo.packagist.org: #StandWithUkraine
./composer.json has been updated
Running composer update nasumilu/geocoder-bundle
Loading composer repositories with package information
Updating dependencies
Lock file operations: 6 installs, 0 updates, 0 removals
  - Locking nasumilu/geocoder (v1.0.0)
  - Locking nasumilu/geocoder-bundle (v1.0.0)
  - Locking symfony/http-client (v6.2.7)
  - Locking symfony/http-client-contracts (v3.2.1)
  - Locking symfony/translation (v6.2.7)
  - Locking symfony/translation-contracts (v3.2.1)
Writing lock file
Installing dependencies from lock file (including require-dev)
Package operations: 6 installs, 0 updates, 0 removals
  - Installing symfony/translation-contracts (v3.2.1): Extracting archive
  - Installing symfony/translation (v6.2.7): Extracting archive
  - Installing symfony/http-client-contracts (v3.2.1): Extracting archive
  - Installing symfony/http-client (v6.2.7): Extracting archive
  - Installing nasumilu/geocoder (v1.0.0): Extracting archive
  - Installing nasumilu/geocoder-bundle (v1.0.0): Extracting archive
Generating autoload files
30 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
```

Depending on the environment composer may prompt to execute the `nasumilu/geocoder-bundle` recipe.

```shell
Symfony operations: 2 recipes (a185950ed51da86ef09d3c6a6d92ce71)
  - Configuring symfony/translation (>=5.3): From github.com/symfony/recipes:main
  -  WARNING  nasumilu/geocoder-bundle (>=1.0): From github.com/nasumilu/flex-recipes:main
    The recipe for this package comes from the "contrib" repository, which is open to community contributions.
    Review the recipe at https://github.com/nasumilu/flex-recipes/tree/main/nasumilu/geocoder-bundle/1.0

    Do you want to execute this recipe?
    [y] Yes
    [n] No
    [a] Yes for all packages, only for the current installation session
    [p] Yes permanently, never ask again for this project
    (defaults to n): y
  - Configuring nasumilu/geocoder-bundle (>=1.0): From github.com/nasumilu/flex-recipes:main
Executing script cache:clear [OK]
Executing script assets:install public [OK]
              
 What's next? 
                      
Some files have been created and/or updated to configure your new packages.
Please review, edit and commit them: these files are yours.
   
 nasumilu/geocoder-bundle  instructions:


   * Geocoder Routes Installed:
     config/routes/geocoder.yaml
        https://[your-server]/services/geocode
        https://[your-server]/services/reverse-geocode

   * Geocode & ReverseGeocoder Services:
     config/packages/geocoder.yaml
        geocoder: us_census
        reverse_geocoder: esri

   * Environment:
     .env
      Review and update to match the service providers requirements.


Read the documentation at https://github.com/nasumilu/geocoder-bundle


No security vulnerability advisories found
Using version ^1.0 for nasumilu/geocoder-bundle
```


## Learn More
- [Configure Bundle Routes](docs/routes.md)
- [Configure Geocoder Service](docs/geocoder.md)
- [Configure Reverse Geocoder Service](docs/reverse-geocoder.md)