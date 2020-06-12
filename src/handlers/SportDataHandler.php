<?php

namespace TeamRanked\handlers;

use TeamRanked\interfaces\DataHandlerInterface;

class SportDataHandler implements DataHandlerInterface
{
    public function handle(array $data)
    {
        $sortedData = $this->sortByScores($data);
        return $this->setDataRanksByScores($sortedData);
    }

    private function sortByScores(array $data): array
    {
        usort($data, function ($a, $b) {
            return $a['scores'] < $b['scores'];
        });

        return $data;
    }

    private function setDataRanksByScores(array $data): array
    {
        $dataWithRanks = [];

        $currentRank = 1;
        $prevItemScore = null;

        foreach ($data as $item) {
            if ($prevItemScore !== null && $prevItemScore !== $item['scores']) {
                $currentRank += 1;
            }

            $dataWithRanks[] = array_merge(['rank' => $currentRank], $item);

            if ($prevItemScore === $item['scores']) {
                $currentRank += 1;
            }

            $prevItemScore = $item['scores'];
        }

        return $dataWithRanks;
    }
}
