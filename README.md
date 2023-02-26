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

```shell
composer require nasumilu/geocoder-bundle
```