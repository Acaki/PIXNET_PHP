<?php

namespace Q3;

class AStar
{
    const DIRECTIONS = [
        [1, 0],
        [0, 1],
        [-1, 0],
        [0, -1],
    ];
    private array $map;
    private array $start;
    private array $end;

    public function __construct($map, $start, $end)
    {
        $this->map = $map;
        $this->start = $start;
        $this->end = $end;
    }

    public function run()
    {
        // Record nodes to be expanded or already expanded
        $openSet = new CoordinatesPriorityQueue();
        $openSet->insert($this->start, 0);
        $closeSet = $cameFrom = $gScore = $fScore = [];
        $gScore[serialize($this->start)] = 0;
        $fScore[serialize($this->start)] = $this->getEstimateDistance($this->start);

        while ($openSet->valid()) {
            // Pop position with minimum cost from the open set
            $current = $openSet->extract();
            $closeSet[] = serialize($current);

            foreach (self::DIRECTIONS as $direction) {
                $neighbor = [$current[0] + $direction[0], $current[1] + $direction[1]];
                // Check if the new position is out of map boundary
                if ($neighbor[0] > (count($this->map) - 1) || $neighbor[0] < 0 ||
                    $neighbor[1] > (count($this->map[count($this->map) - 1]) - 1) || $neighbor[1] < 0) {
                    continue;
                }
                // Check if we reached the target position
                if ($neighbor === $this->end) {
                    $path = [$neighbor];
                    while ($current) {
                        $path[] = $current;
                        $current = $cameFrom[serialize($current)];
                    }
                    return array_reverse($path);
                }
                // Check if the new position is blocked or already closed
                if ($this->map[$neighbor[0]][$neighbor[1]] !== '0' || in_array(serialize($neighbor), $closeSet)) {
                    continue;
                }

                $tentativeGScore = $gScore[serialize($current)] + 1;
                $neighborGScore = $gScore[serialize($neighbor)] ?? INF;
                if ($tentativeGScore < $neighborGScore) {
                    $cameFrom[serialize($neighbor)] = $current;
                    $gScore[serialize($neighbor)] = $tentativeGScore;
                    $neighborFScore = $tentativeGScore + $this->getEstimateDistance($neighbor);
                    $fScore[serialize($neighbor)] = $neighborFScore;
                    $openSet->insert($neighbor, $neighborFScore);
                }
            }
        }

        return [];
    }

    private function getEstimateDistance($start)
    {
        return sqrt(pow($start[0] - $this->end[0], 2) + pow($start[1] - $this->end[1], 2));
    }
}
