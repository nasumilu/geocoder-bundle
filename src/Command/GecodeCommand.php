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
use Nasumilu\Spatial\GeocoderInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'nasumilu:geocode', description: 'Geocodes an address candidate')]
class GecodeCommand extends Command
{
    public function __construct(private readonly GeocoderInterface $geocoder)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('address', 'a', InputOption::VALUE_OPTIONAL);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (null === $input->getOption('address')) {
            $style = new SymfonyStyle($input, $output);
            $address = $style->ask('Enter the address: ', null, function(string|null $value): string {
                if(empty($value)) {
                    throw new InvalidArgumentException('Address is required, none found!');
                }
                return $value;
            });
            $input->setOption('address', $address);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $address = $input->getOption('address');
        $candidates = $this->geocoder->geocode($address);
        $output = new SymfonyStyle($input, $output);
        $output->table(
            ['Address', 'Score', 'Location'],
            array_map(
                fn(AddressCandidate $value): array => [$value->getAddress(), $value->getScore(), vsprintf('%s, %s', $value->getLocation())],
                $candidates
            )
        );
        return Command::SUCCESS;
    }
}