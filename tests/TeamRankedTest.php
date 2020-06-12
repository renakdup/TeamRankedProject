<?php

namespace TeamRanked\tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TeamRanked\handlers\SportDataHandler;
use TeamRanked\interfaces\DataProviderInterface;
use TeamRanked\readers\JsonReader;
use TeamRanked\renders\JsonRender;
use TeamRanked\TeamRanked;

class TeamRankedTest extends TestCase
{
    protected string $pathToFixtures = __DIR__ . '/fixtures';

    protected MockObject $stubDataProvider;
    protected JsonReader $parser;
    protected SportDataHandler $handler;
    protected JsonRender $render;

    protected function setUp(): void
    {
        $this->stubDataProvider = $this->createMock(DataProviderInterface::class);
        $this->parser = new JsonReader();
        $this->handler = new SportDataHandler();
        $this->render = new JsonRender();
    }

    /**
     * @dataProvider contentSuccessDataProvider
     */
    public function testTeamRankedSuccess($rawContent, $expected)
    {
        $this->stubDataProvider->method('getData')
                               ->willReturn($rawContent);

        $teamRanked = new TeamRanked($this->stubDataProvider, $this->parser, $this->handler, $this->render);
        $teamRanked->init();

        $expected = json_decode($expected);
        $actual = json_decode($teamRanked->getRenderedData());

        self::assertEquals($expected, $actual);
    }

    public function contentSuccessDataProvider()
    {
        return [
            [
                file_get_contents($this->pathToFixtures . '/example1-success.json'),
                file_get_contents($this->pathToFixtures . '/result1-success.json'),
            ],
            [
                file_get_contents($this->pathToFixtures . '/example2-success.json'),
                file_get_contents($this->pathToFixtures . '/result2-success.json'),
            ],
        ];
    }

    public function testTeamRankedJsonException()
    {
        $rawContent = file_get_contents($this->pathToFixtures . '/example3-fail.txt');

        self::expectException(\JsonException::class);

        $this->stubDataProvider->method('getData')
                               ->willReturn($rawContent);

        $teamRanked = new TeamRanked($this->stubDataProvider, $this->parser, $this->handler, $this->render);
        $teamRanked->init();
    }
}
