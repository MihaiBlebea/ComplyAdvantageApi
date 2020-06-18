<?php

namespace Chip\ComplyAdvantageApi\Responses;

class BaseResponse
{
    /** @var array */
    protected $content;

    public function __construct(array $content)
    {
        $this->content = $content["content"];
    }

    public function getContent(): array
    {
        return $this->content;
    }
}