<?php

namespace Chip\ComplyAdvantageApi\Responses;

use Chip\ComplyAdvantageApi\Responses\BaseResponse;

class CreateSearchResponse extends BaseResponse
{
    public function getId(): int
    {
        return $this->content["data"]["id"];
    }

    public function getRef(): string
    {
        return $this->content["data"]["ref"];
    }

    public function getHitsCount(): int
    {
        return $this->content["data"]["total_hits"];
    }

    public function getHits(): array
    {
        if ($this->getHitsCount() === 0) {
            return [];
        }
        return $this->content["data"]["hits"];
    }

    public function getMatchStatus(): string 
    {
        return $this->content["data"]["match_status"];
    }

    public function getRiskLevel(): string
    {
        return $this->content["data"]["risk_level"];
    }

    public function getClientRef(): string
    {
        return $this->content["data"]["client_ref"];
    }
}