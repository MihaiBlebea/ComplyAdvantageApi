<?php

namespace Chip\ComplyAdvantageApi;

class SearchTerm
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

    public function setFirstName(string $firstName)
    {
        $this->params['first_name'] = $firstName;
    }

    public function setMiddleName(string $middleName)
    {
        $this->params['middle_name'] = $middleName;
    }

    public function setLastName(string $lastName)
    {
        $this->params['last_name'] = $lastName;
    }

    public function toArray(): array
    {
        return $this->params;
    }
}