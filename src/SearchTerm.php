<?php

namespace Chip\ComplyAdvantageApi;

class SearchTerm
{
    /** @var array */
    private $params;

    /** @var string */
    private $param;

    public function __construct(array $params = null)
    {
        if ($params === null) {
            $this->params = [];
        }
        $this->params = $params;
    }

    public static function fromString(string $term)
    {
        $instance = new SearchTerm();
        $instance->setTerm($term);

        return $instance;
    }

    public function setTerm(string $term)
    {
        $this->params = [];
        $this->param = $term;
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

    public function getValue(): array
    {
        if (count($this->params) > 0) {
            return $this->params;
        }
        return $this->param;
    }
}