<?php

namespace Chip\Tests\Requests;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\SearchTerm;
use Chip\ComplyAdvantageApi\Filters\FilterFactory;
use Chip\ComplyAdvantageApi\Requests\CreateSearchRequest;
use Chip\ComplyAdvantageApi\Exceptions\InvalidCreateException;

class CreateSearchRequestTest extends TestCase
{
    private const KEYS = [
        'search_term',
        'client_ref',
        'fuzziness',
        'filters',
        'share_url',
        'offset',
        'limit'
    ];

    private function assertHasKeys(array $body)
    {
        foreach (self::KEYS as $key) {
            $this->assertArrayHasKey($key, $body);
        }
    }

    public function testCanInstWithConstructor()
    {
        $request = new CreateSearchRequest([
            'search_term' => [
                'first_name' => 'Mihai',
                'last_name' => 'Blebea'
            ],
            'client_ref' => 'CHIP_10',
            'fuzziness' => 0.6,
            'filters' => [
                'types'=> ['sanction', 'warning'],
                'birth_year' => '1989',
                'country_codes' => ['RO', 'UK']
            ],
            'share_url' => 1,
            'offset' => 1,
            'limit' => 100
        ]);

        $this->assertHasKeys($request->toArray());
    }

    public function testCanInstFromArray()
    {
        $request = CreateSearchRequest::fromArray([
            'search_term' => [
                'first_name' => 'Mihai',
                'last_name' => 'Blebea'
            ],
            'client_ref' => 'CHIP_10',
            'fuzziness' => 0.6,
            'filters' => [
                'types'=> ['sanction', 'warning'],
                'birth_year' => '1989',
                'country_codes' => ['RO', 'UK']
            ],
            'share_url' => 1,
            'offset' => 1,
            'limit' => 100
        ]);

        $this->assertHasKeys($request->toArray());
    }

    public function testThrowExceptionWithEmptyArray()
    {
        $this->expectException(InvalidCreateException::class);

        CreateSearchRequest::fromArray([]);
    }

    public function testAddFilters()
    {
        $request = new CreateSearchRequest();

        $searchTerm = new SearchTerm([
            'first_name' => 'Mihai',
            'last_name' => 'Blebea'
        ]);

        $request->setSearchTerm($searchTerm);
        $request->setClientRef('CHIP_10');
        $request->setFuzziness(0.5);
        
        $typeFilter = FilterFactory::build('TypeFilter', ['sanction', 'warning']);
        $countryFilter = FilterFactory::build('CountryFilter', ['RO']);
        $birthYearFilter = FilterFactory::build('BirthYearFilter', '1989');

        $request->setFilters($typeFilter, $countryFilter, $birthYearFilter);

        $request->shouldShareUrl(true);
        $request->setPagination(1, 100);

        $this->assertHasKeys($request->toArray());
    }
}