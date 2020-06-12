<?php

declare(strict_types=1);

namespace TeamRanked;

use TeamRanked\interfaces\DataProviderInterface;
use TeamRanked\interfaces\ReaderInterface;
use TeamRanked\interfaces\DataHandlerInterface;
use TeamRanked\interfaces\RenderInterface;

class TeamRanked
{
    private DataProviderInterface $provider;
    private ReaderInterface $parser;
    private DataHandlerInterface $formatter;
    private RenderInterface $render;

    private ?string $renderedData = null;

    public function __construct(
        DataProviderInterface $provider,
        ReaderInterface $parser,
        DataHandlerInterface $formatter,
        RenderInterface $render
    ) {
        $this->provider = $provider;
        $this->parser = $parser;
        $this->formatter = $formatter;
        $this->render = $render;
    }

    public function init()
    {
        $data = $this->provider->getData();
        $parsedData = $this->parser->read($data);

        $formattedData = $this->formatter->handle($parsedData);
        $this->renderedData = $this->render->render($formattedData);
    }

    public function getRenderedData(): ?string
    {
        return $this->renderedData;
    }
}
