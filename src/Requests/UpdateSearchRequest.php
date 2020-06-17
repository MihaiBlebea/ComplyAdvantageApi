<?php

namespace Chip\ComplyAdvantageApi\Requests;

use Chip\ComplyAdvantageApi\Exceptions\InvalidUpdateException;

class UpdateSearchRequest
{
    /** @var array */
    protected $params;

    private const VALID_STATUSES = [
        'no_match', 
        'false_positive', 
        'potential_match', 
        'true_positive',
        'unknown'
    ];

    private const VALID_LEVELS = [
        'low', 
        'medium', 
        'high', 
        'unknown'
    ];

    public function __construct(array $params = null)
    {
        if ($params === null) {
            $this->params = [];
        }
        $this->params = $params;
    }

    public function setMatchStatus(string $status)
    {
        if ($this->isValidMatchStatus($status) === false) {
            throw new InvalidUpdateException('Update for status ' . $status . ' is invalid');
        }

        $this->params['match_status'] = $status;
    }

    public function setRiskLevel(string $level)
    {
        if ($this->isValidRiskLevel($level) === false) {
            throw new InvalidUpdateException('Update for risk level ' . $level . ' is invalid');
        }

        $this->params['risk_level'] = $level;
    }

    public function setAssigneeId(int $id)
    {
        $this->params['assignee_id'] = $id;
    }

    public function setWhitelist(bool $whitelisted)
    {
        $this->params['is_whitelisted'] = $whitelisted;
    }

    private function isValidMatchStatus(string $status)
    {
        return in_array($status, self::VALID_STATUSES);
    }

    private function isValidRiskLevel(string $level)
    {
        return in_array($level, self::VALID_LEVELS);
    }

    public function toArray(): array
    {
        return $this->params;
    }
}