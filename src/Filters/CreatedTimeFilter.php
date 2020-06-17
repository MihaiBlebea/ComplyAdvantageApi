<?php

namespace Chip\ComplyAdvantageApi\Filters;

use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;
use Chip\ComplyAdvantageApi\Filters\Filter;
use DateTime;

class CreatedTimeFilter implements Filter
{
    /** @var string */
    private $to;

    /** @var string */
    private $from;

    private const NAME = "CreatedTimeFilter";

    public function __construct(array $times)
    {
        if ($this->isValid($times) === false) {
            throw new InvalidFilterException("Filter created time is invalid");
        }
        
        if (array_key_exists('to', $times)) {
            $this->to = date_format($times['to'], "Y-m-d");
        }

        if (array_key_exists('from', $times)) {
            $this->from = date_format($times['from'], "Y-m-d");
        }
    }

    private function isValid(array $times)
    {
        if (array_key_exists('to', $times) === false && array_key_exists('from', $times) === false) {
            return false;
        }

        if (array_key_exists('to', $times) === true && !($times['to'] instanceof DateTime)) {
            return false;
        }

        if (array_key_exists('from', $times) === true && !($times['from'] instanceof DateTime)) {
            return false;
        }

        if (array_key_exists('to', $times) === true && array_key_exists('from', $times) === true) {
            if ($times['from'] > $times['to']) {
                return false;
            }
        }

        return true;
    }

    public function getValue(): array
    {
        $response = [];
        if ($this->from !== null) {
            $response['created_at_from'] = $this->from;
        }

        if ($this->to !== null) {
            $response['created_at_to'] = $this->to;
        }
        
        return $response;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}