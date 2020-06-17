<?php

namespace Chip\ComplyAdvantageApi\Requests;

use Chip\ComplyAdvantageApi\SearchTerm;
use Chip\ComplyAdvantageApi\Filters\Filter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class CreateSearchRequest
{
    /** @var array */
    private $params;

    public function __construct(array $params = null)
    {
        if ($params === null) {
            $this->params = [];
        }
        $this->params = $params;
    }

    public function setSearchTerm(SearchTerm $searchTerm)
    {
        $this->params['search_term'] = $searchTerm->getValue();
    }

    public function setClientRef(string $clientRef)
    {
        $this->params['client_ref'] = $clientRef;
    }

    public function setExactMatch(bool $exactMatch)
    {
        $this->params['exact_match'] = $exactMatch;
    }

    public function setFuzziness(float $fuziness)
    {
        $this->params['fuzziness'] = $fuziness;
    }

    public function setFilters(Filter ...$filters)
    {
        $this->params['filters'] = [];
        foreach ($filters as $filter) {
            switch ($filter->getName()) {
                case 'BirthYearFilter':
                    $this->params['filters']['birth_year'] = $filter->getValue();
                    break;
                case 'CountryFilter':
                    $this->params['filters']['country_codes'] = $filter->getValue();
                    break;
                case 'TypeFilter':
                    $this->params['filters']['types'] = $filter->getValue();
                    break;
                default:
                    throw new InvalidFilterException('Invalid filter with name ' . $filter->getName());
            }
        }
    }

    public function shouldShareUrl(bool $value)
    {
        $this->params['share_url'] = $value ? 1 : 0;
    }

    public function setPagination(int $offset, int $limit)
    {
        $this->params['offset'] = $offset;
        $this->params['limit'] = $limit;
    }

    public function toArray(): array
    {
        return $this->params;
    }
}