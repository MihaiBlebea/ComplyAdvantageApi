<?php

namespace Chip\ComplyAdvantageApi\Filters;

use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;
use Chip\ComplyAdvantageApi\Filters\Filter;

class RiskLevelFilter implements Filter
{
    /** @var array */
    private $levels;

    private const NAME = "RiskLevelFilter";

    private const VALID_LEVELS = [
        'low', 
        'medium', 
        'high', 
        'unknown'
    ];

    public function __construct(array $levels)
    {
        if (count($levels) === 0) {
            throw new InvalidFilterException("Filter risk level was supplied empty array");
        }

        foreach($levels as $level) {
            if ($this->isValid($level) === false) {
                throw new InvalidFilterException("Filter level " . $level . " is invalid");
            }
        }
        $this->levels = $levels;
    }

    public static function fromArray(array $levels)
    {
        return new RiskLevelFilter($levels);
    }

    public function addLevel(string $level)
    {
        if ($this->isValid($level) === false) {
            throw new InvalidFilterException("Filter level " . $level . " is invalid");
        }
        $this->levels[] = $level;
    }

    private function isValid(string $level)
    {
        return in_array($level, self::VALID_LEVELS);
    }

    public function getValue()
    {
        return $this->levels;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}