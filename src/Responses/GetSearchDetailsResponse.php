<?php

namespace Chip\ComplyAdvantageApi\Responses;

use Chip\ComplyAdvantageApi\Responses\BaseResponse;

class GetSearchDetailsResponse extends BaseResponse 
{
    public function getData(): array
    {
        return $this->content['data'];
    }

    public function getFilters(): array
    {
        return $this->content['filters'];
    }

    public function getMatchStatus(): string
    {
        return $this->content['match_status'];
    }

    public function getRiskLevel(): string
    {
        return $this->content['risk_level'];
    }

    public function getHitsCount(): int
    {
        return $this->content['total_hits'];
    }
}