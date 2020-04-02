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
    private Node $start;
    private Node $end;

    public function __construct($map, $start, $end)
    {
        $this->map = $map;
        $this->start = $start;
        $this->end = $end;
    }

    public function run()
    {
        $openedNodes = $closedNodes = [];
        $openedNodes[] = $this->start;

        while (count($openedNodes)) {
            $currentIdx = 0;
            $currentNode = $openedNodes[$currentIdx];
            foreach ($openedNodes as $idx => $openedNode) {
                if ($openedNode->f < $currentNode->f) {
                    $currentIdx = $idx;
                    $currentNode = $openedNode;
                }
            }
            $closedNodes[] = $currentNode;
            unset($openedNodes[$currentIdx]);
            $openedNodes = array_values($openedNodes);

            foreach (self::DIRECTIONS as $direction) {
                $newPosition = [$currentNode->position[0] + $direction[0], $currentNode->position[1] + $direction[1]];
                if ($newPosition[0] > (count($this->map) - 1) || $newPosition[0] < 0 ||
                    $newPosition[1] > (count($this->map[count($this->map) - 1]) - 1) || $newPosition[1] < 0) {
                    continue;
                }
                $newNode = new Node($newPosition, $currentNode);
                if ($newNode->position === $this->end->position) {
                    $path = [];
                    $current = $newNode;
                    while ($current) {
                        $path[] = $current->position;
                        $current = $current->parent;
                    }
                    return array_reverse($path);
                }
                if ($this->map[$newNode->position[0]][$newNode->position[1]] !== '0') {
                    continue;
                }

                $isNewNodeClosed = false;
                foreach ($closedNodes as $closedNode) {
                    if ($newNode->position === $closedNode->position) {
                        $isNewNodeClosed = true;
                        break;
                    }
                }
                if ($isNewNodeClosed) {
                    continue;
                }

                $newNode->g = $currentNode->g + 1;
                $newNode->h = sqrt(pow($newNode->position[0] - $this->end->position[0], 2) +
                    pow($newNode->position[1] - $this->end->position[1], 2));
                $newNode->f = $newNode->g + $newNode->h;

                $isChildOpenedAndFarther = false;
                foreach ($openedNodes as $openedNode) {
                    if ($newNode->position === $openedNode->position && $newNode->g > $openedNode->g) {
                        $isChildOpenedAndFarther = true;
                        break;
                    }
                }
                if ($isChildOpenedAndFarther) {
                    continue;
                }

                $openedNodes[] = $newNode;
            }
        }

        return [];
    }
}
