<?php

namespace Q3;

require_once '../vendor/autoload.php';

function powerSet($array)
{
    $results = [[]];

    foreach ($array as $element) {
        foreach ($results as $combination) {
            $results[] = array_merge([$element], $combination);
        }
    }

    return $results;
}

function getIndex($current, $set)
{
    return json_encode(['current' => $current, 'set' => $set]);
}

function getCost($locations, $prevLocation, $minCostDp)
{
    if (($key = array_search($prevLocation, $locations)) !== false) {
        unset($locations[$key]);
        $locations = array_values($locations);
        return $minCostDp[getIndex($prevLocation, $locations)] ?? 0;
    }

    return 0;
}

while (true) {
    $map = [];
    while (($row = readline('Enter a map: ')) !== 'end') {
        $map[] = str_split($row);
    }

    $mouseLocations = [];
    $mouseSymbols = ['X', 'Y', 'Z'];
    $start = new Node();
    foreach ($map as $idx => $row) {
        if ($target = array_search('C', $row)) {
            $start->position = [$idx, $target];
        }
        foreach ($mouseSymbols as $mouseSymbol) {
            if ($target = array_search($mouseSymbol, $row)) {
                $mouseLocations[$mouseSymbol] = [$idx, $target];
            }
        }
    }
    $mouseCombinations = powerSet($mouseLocations);
    $minCostDp = $parent = [];
    foreach ($mouseCombinations as $mouseCombination) {
        foreach ($mouseLocations as $mouseLocation) {
            if (in_array($mouseLocation, $mouseCombination)) {
                continue;
            }
            $minCost = INF;
            $minPrevNode = $start->position;
            foreach ($mouseCombination as $prevLocation) {
                $prevToCurrent = count((new AStar($map, new Node($prevLocation), new Node($mouseLocation)))->run()) - 2;
                if ($prevToCurrent < 0) {
                    $prevToCurrent = INF;
                }
                $minSetToCurrent = getCost($mouseCombination, $prevLocation, $minCostDp);
                $cost = $prevToCurrent + $minSetToCurrent;
                if ($cost < $minCost) {
                    $minCost = $cost;
                    $minPrevNode = $prevLocation;
                }
            }

            if (empty($mouseCombination)) {
                $minCost = 0;
            }
            $index = getIndex($mouseLocation, $mouseCombination);
            $minCostDp[$index] = $minCost;
            $parent[$index] = $minPrevNode;
        }
    }
    $min = INF;
    $prevLocation = [];
    $positionSet = end($mouseCombinations);
    foreach ($mouseLocations as $mouseLocation) {
        $prevToCurrent = count((new AStar($map, new Node($mouseLocation), $start))->run()) - 2;
        $minSetToCurrent = getCost($positionSet, $mouseLocation, $minCostDp);
        $cost = $prevToCurrent + $minSetToCurrent;
        if ($cost < $min) {
            $min = $cost;
            $prevLocation = $mouseLocation;
        }
    }

    if ($min === INF) {
        print_r('無解');
    }

    $parent[getIndex($start->position, $positionSet)] = $prevLocation;

    $startValue = end($parent);
    reset($parent);
    while ($startValue) {
        $key = array_search($startValue, $positionSet);
        unset($positionSet[$key]);
        $positionSet = array_values($positionSet);
        $startKey = getIndex($startValue, $positionSet);
        $cost = $min - $minCostDp[$startKey];
        $min = $minCostDp[$startKey];
        if ($startValue) {
            if ($mouseName = array_search($startValue, $mouseLocations)) {
                print_r($cost . $mouseName);
            }
        }
        $startValue = $parent[$startKey];
    }
    print_r(PHP_EOL);
}
