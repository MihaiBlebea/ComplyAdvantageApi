<?php

namespace Chip\ComplyAdvantageApi\Responses;

class CreateSearchResponse
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data["content"]["data"];
    }

    public function getId(): int
    {
        return $this->data["id"];
    }

    public function getRef(): string
    {
        return $this->data["ref"];
    }

    public function getHitsCount(): int
    {
        return $this->data["total_hits"];
    }

    public function getHits(): array
    {
        if ($this->getHitsCount() === 0) {
            return [];
        }
        return $this->data["hits"];
    }

    public function getMatchStatus(): string 
    {
        return $this->data["match_status"];
    }

    public function getRiskLevel(): string
    {
        return $this->data["risk_level"];
    }

    public function getClientRef(): string
    {
        return $this->data["client_ref"];
    }
}