<?php

namespace TeamRanked\handlers;

use TeamRanked\interfaces\DataHandlerInterface;

class SportDataHandler implements DataHandlerInterface
{
    public function handle(array $data)
    {
        $dataWithRanks = $this->setDataRanksByScores($data);
        return $this->sortByRanks($dataWithRanks);
    }

    private function sortByRanks(array $data): array
    {
        usort($data, function ($a, $b) {
            return $a['rank'] <=> $b['rank'];
        });

        return $data;
    }

    private function setDataRanksByScores(array $data): array
    {
        $scoresWithRanks = collect($data)
            ->pluck('scores')
            ->unique()
            ->sortDesc()
            ->values()
            ->flip()
            ->all();

        return collect($data)
            ->map(function ($item) use ($scoresWithRanks) {
                return array_merge([
                    'rank' => $scoresWithRanks[$item['scores']] + 1
                ], $item);
            })
            ->all();
    }
}
