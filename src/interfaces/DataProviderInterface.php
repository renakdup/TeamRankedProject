<?php

namespace TeamRanked\interfaces;

interface DataProviderInterface
{
    public function __construct($source);

    public function getData(): string;
}
