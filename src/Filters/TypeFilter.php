<?php

namespace Chip\ComplyAdvantageApi\Filters;

use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;
use Chip\ComplyAdvantageApi\Filters\Filter;

class TypeFilter implements Filter
{
    /** @var array */
    private $types;

    private const NAME = "TypeFilter";

    private const VALID_TYPES = [
        'sanction',
        'warning',
        'fitness-probity',
        'pep',
        'pep-class-1',
        'pep-class-2',
        'pep-class-3',
        'pep-class-4',
        'adverse-media',
        'adverse-media-financial-crime',
        'adverse-media-violent-crime',
        'adverse-media-sexual-crime',
        'adverse-media-terrorism',
        'adverse-media-fraud',
        'adverse-media-narcotics',
        'adverse-media-general'
    ];

    public function __construct(array $types)
    {
        if (count($types) === 0) {
            throw new InvalidFilterException("Filter type was supplied empty array");
        }

        foreach($types as $type) {
            if ($this->isValid($type) === false) {
                throw new InvalidFilterException("Filter type " . $type . " is invalid");
            }
        }
        $this->types = $types;
    }

    public static function fromArray(array $types)
    {
        return new TypeFilter($types);
    }

    public function addType(string $type)
    {
        if ($this->isValid($type) === false) {
            throw new InvalidFilterException("Filter type " . $type . " is invalid");
        }
        $this->types[] = $type;
    }

    private function isValid(string $type)
    {
        return in_array($type, self::VALID_TYPES);
    }

    public function getValue()
    {
        return $this->types;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}