<?php

declare(strict_types=1);

namespace TeamRanked\readers;

use TeamRanked\interfaces\ReaderInterface;

class JsonReader implements ReaderInterface
{
    public function read(string $data): array
    {
        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }
}
