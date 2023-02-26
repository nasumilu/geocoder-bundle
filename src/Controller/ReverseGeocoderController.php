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
use Nasumilu\Spatial\ReverseGeocoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ReverseGeocoderController
{

    public function __construct(private readonly ReverseGeocoderInterface $reverseGeocoder)
    {
    }

    public function __invoke(Request $request): JsonResponse {
        try {
            if (null === $x = $request->query->get('lng')) {
                throw new UnprocessableEntityHttpException('The longitude (x-coordinate) is required!');
            }

            if (null === $y = $request->query->get('lat')) {
                throw new UnprocessableEntityHttpException('The latitude (y-coordinate) is required!');
            }
            try {
                $payload = $this->reverseGeocoder->reverseGeocode([$x, $y]);
                return new JsonResponse($payload);
            } catch(GeocoderException $ex) {
                throw new HttpException(500, previous: $ex);
            }
        } catch (HttpExceptionInterface $ex) {
            return new JsonResponse([
                'error' => true,
                'code' => $ex->getStatusCode(),
                'message' => $ex->getMessage()
            ], status: $ex->getStatusCode());
        }
    }
}