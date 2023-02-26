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
namespace Nasumilu\GeocoderBundle\Command;

use Nasumilu\Spatial\AddressCandidate;
use Nasumilu\Spatial\ReverseGeocoderInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'nasumilu:reverse-geocode', description: 'Reverse geocodes an ordered pair (lng, lat) into an address candidate')]
class ReverseGecodeCommand extends Command
{
    public function __construct(private readonly ReverseGeocoderInterface $geocoder)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('lng', 'x', InputOption::VALUE_OPTIONAL);
        $this->addOption('lat', 'y', InputOption::VALUE_OPTIONAL);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {

        if (null === $input->getOption('lng')) {
            $input->setOption(
                'lng',
                $this->promptOrdinate('Enter the longitude (x-coordinate): ', $input, $output)
            );
        }

        if (null === $input->getOption('lat')) {
            $input->setOption(
                'lat',
                $this->promptOrdinate('Enter the latitude (y-coordinate): ', $input, $output)
            );
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $x = $input->getOption('lng');
        $y = $input->getOption('lat');
        $candidates = [$this->geocoder->reverseGeocode([$x,$y])];
        $output = new SymfonyStyle($input, $output);
        $output->table(
            ['Address', 'Location'],
            array_map(
                fn(AddressCandidate $value): array => [$value->getAddress(), vsprintf('%s, %s', $value->getLocation())],
                $candidates
            )
        );
        return Command::SUCCESS;
    }


    private function promptOrdinate(string $question, InputInterface $input, OutputInterface $output): string {
        $style = new SymfonyStyle($input, $output);
        return $style->ask($question, null, function(string|null $value): string {
            if(!is_numeric($value)) {
                throw new InvalidArgumentException('Value is required and must be numeric!');
            }
            return $value;
        });
    }
}