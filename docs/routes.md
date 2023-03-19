# nasumilu/geocoder-bundle Routes

This bundle provides two endpoints which provide geocoding and reverse geocoding.

## Geocode 

By default, the bundle configures the route as `http(s)://your-server.com/services/geocode` and maybe installed as 
part of an existing Symfony application or as a standalone service.

### Response

The response body is a [GeoJson FeatureCollection](https://www.rfc-editor.org/rfc/rfc7946#section-3.3) but does not
have the `bbox` member. 

Each feature in the collection is a point (x,y) of the World Geodetic System 1984 (WGS 84) coordinate system as 
decimal degrees with a `properties.address` member of the address found at that location. The feature collection also
has a `properties.address` member containing the original address used in the query. 

### Example Output
Willis (Sears) Tower, Chicago, IL
**GET** _https://localhost:8001/services/geocode?address=233%20S%20Wacker%20Dr,%20Chicago,%20IL%2060606_

```json
{
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [
          -87.6366646681363,
          41.878512134686744
        ]
      },
      "properties": {
        "address": "233 S WACKER DR, CHICAGO, IL, 60606"
      }
    }
  ],
  "properties": {
    "search_address": "233 S Wacker Dr, Chicago, IL 60606"
  }
}
```

## Reverse Geocoder

By default, the bundle configures the route as `http(s)://your-server.com/services/reverse-geocode` and maybe installed as
part of an existing Symfony application or as a standalone service.

### Response

The reverse-geocode response is a [GeoJson Feature](https://www.rfc-editor.org/rfc/rfc7946#section-3.2).

The feature is a point (x,y) of the World Geodetic System 1984 (WGS 84) coordinate system as decimal degrees with a 
`properties.address` member of the address found at that location.

### Example

**GET** _https://localhost:8001/services/reverse-geocode?lng=-87.6366646681363&lat=41.878512134686744_
```json
{
  "type": "Feature",
  "geometry": {
    "type": "Point",
    "coordinates": [
      "-87.6366646681363",
      "41.878512134686744"
    ]
  },
  "properties": {
    "address": "259 S Wacker Dr, Chicago, IL 60606-6311, United States"
  }
}
```

- [Back to nasumilu/geocoder-bundle](../README.md)