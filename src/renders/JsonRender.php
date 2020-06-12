<?php

declare(strict_types=1);

namespace TeamRanked\renders;

use TeamRanked\interfaces\RenderInterface;

class JsonRender implements RenderInterface
{
    public function render($data): string
    {
        return json_encode($data);
    }
}
