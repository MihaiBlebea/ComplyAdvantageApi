<?php

namespace Chip\ComplyAdvantageApi\Requests;

use Chip\ComplyAdvantageApi\Exceptions\InvalidUpdateException;
use Chip\ComplyAdvantageApi\Filters\MatchStatusFilter;
use Chip\ComplyAdvantageApi\Filters\RiskLevelFilter;

class UpdateSearchRequest
{
    /** @var array */
    protected $params;

    public function __construct(array $params = null)
    {
        if ($params === null) {
            $this->params = [];
        }
        $this->params = $params;

        if ($params !== null && array_key_exists('match_status', $params)) {
            $this->setMatchStatus($params['match_status']);
        }

        if ($params !== null && array_key_exists('risk_level', $params)) {
            $this->setRiskLevel($params['risk_level']);
        }
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
        return in_array($status, MatchStatusFilter::VALID_STATUSES);
    }

    private function isValidRiskLevel(string $level)
    {
        return in_array($level, RiskLevelFilter::VALID_LEVELS);
    }

    public function toArray(): array
    {
        return $this->params;
    }
}