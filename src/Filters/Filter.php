<?php

namespace Chip\ComplyAdvantageApi\Filters;

interface Filter
{
    public function getValue();

    public function getName(): string;
}