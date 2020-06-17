<?php

namespace Chip\ComplyAdvantageApi\Requests;

class UpdateSearchEntityRequest extends UpdateSearchRequest
{
    public function setEntities(array $entities)
    {
        $this->params['entities'] = $entities;
    }

    public function addEntity(string $entity)
    {
        $this->params['entities'][] = $entity;
    }
}