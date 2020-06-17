<?php

namespace Chip\ComplyAdvantageApi\Filters;

use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;
use Chip\ComplyAdvantageApi\Filters\Filter;

class MatchStatusFilter implements Filter
{
    /** @var array */
    private $statuses;

    private const NAME = "MatchStatusFilter";

    public const VALID_STATUSES = [
        'no_match', 
        'false_positive', 
        'potential_match', 
        'true_positive',
        'unknown'
    ];

    public function __construct(array $statuses)
    {
        if (count($statuses) === 0) {
            throw new InvalidFilterException("Filter status was supplied empty array");
        }

        foreach($statuses as $status) {
            if ($this->isValid($status) === false) {
                throw new InvalidFilterException("Filter status " . $status . " is invalid");
            }
        }
        $this->statuses = $statuses;
    }

    public static function fromArray(array $statuses)
    {
        return new MatchStatusFilter($statuses);
    }

    public function addStatus(string $status)
    {
        if ($this->isValid($status) === false) {
            throw new InvalidFilterException("Filter status " . $status . " is invalid");
        }
        $this->statuses[] = $status;
    }

    private function isValid(string $status)
    {
        return in_array($status, self::VALID_STATUSES);
    }

    public function getValue()
    {
        return $this->statuses;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}