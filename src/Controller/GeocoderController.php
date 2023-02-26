<?php
/**
 *    Copyright 2023 Michael Lucas
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0

 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Nasumilu\GeocoderBundle\Controller;

use Nasumilu\Spatial\GeocoderException;
use Nasumilu\Spatial\GeocoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

#[AsController]
class GeocoderController
{

    public function __construct(private readonly GeocoderInterface $geocoder)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $featureCollection = ['type' => 'FeatureCollection', 'features' => [], 'properties' => ['search_address' => null]];
        try {
            if (null == $featureCollection['properties']['search_address'] = $request->query->get('address')) {
                throw new UnprocessableEntityHttpException('Address query parameter is required, no found!');
            }
            try {
                $featureCollection['features'] = $this->geocoder->geocode($featureCollection['properties']['search_address']);
            } catch (GeocoderException $ex) {
                throw new HttpException(500, previous: $ex);
            }
        } catch (HttpExceptionInterface $ex) {
            return new JsonResponse([
                'error' => true,
                'code' => $ex->getStatusCode(),
                'message' => $ex->getMessage()
            ], status: $ex->getStatusCode());
        }
        return new JsonResponse($featureCollection);
    }

}