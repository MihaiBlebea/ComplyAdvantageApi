<?php

namespace Chip\ComplyAdvantageApi\Responses;

class GetSearchResponse
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data["content"]["data"];
    }

    public function getSearch(): int
    {
        return $this->data["id"];
    }
}