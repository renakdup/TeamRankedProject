<?php

declare(strict_types=1);

namespace TeamRanked\providers;

use TeamRanked\interfaces\DataProviderInterface;

class UrlDataProvider implements DataProviderInterface
{
    private ?string $source;

    public function __construct($source)
    {
        $this->source = $source;
    }

    public function getData(): string
    {
        if ($this->source === null) {
            throw new \Exception("Not correct source '{$this->source}'");
        }

        $responseCode = $this->getHttpResponseCode($this->source);

        if ($responseCode !== '200') {
            throw new \Exception("Content have not got from source '{$this->source}'");
        }

        return file_get_contents($this->source);
    }

    private function getHttpResponseCode(string $url): ?string
    {
        @$headers = get_headers($url);

        if (! $headers) {
            return null;
        }

        return mb_substr($headers[0], 9, 3, 'UTF-8');
    }
}
