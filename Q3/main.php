<?php

namespace Q3;

use function foo\func;

require_once 'vendor/autoload.php';

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
    return serialize(['current' => $current, 'set' => $set]);
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
        if ($row === 'exit') {
            exit(0);
        }
    }

    // Get coordinates of mouses and their symbols
    $mouseLocations = [];
    $mouseSymbols = ['X', 'Y', 'Z'];
    $start = [0, 0];
    foreach ($map as $idx => $row) {
        if (($target = array_search('C', $row)) !== false) {
            $start = [$idx, $target];
        }
        foreach ($mouseSymbols as $mouseSymbol) {
            if (($target = array_search($mouseSymbol, $row)) !== false) {
                $mouseLocations[$mouseSymbol] = [$idx, $target];
            }
        }
    }
    // {}, {mouse1}, {mouse2}, {mouse1, mouse2}, {mouse3}, ... , {mouse1, mouse2, mouse3}
    $mouseLocationSets = powerSet($mouseLocations);
    $minCostDp = $parent = [];
    // DP formula: g(i, S) = min { C(i, k) + g(k, S - {k}) }, k ∈ S
    // $mouseLocationSet = S
    foreach ($mouseLocationSets as $mouseLocationSet) {
        // $mouseLocation = i
        foreach ($mouseLocations as $mouseLocation) {
            if (in_array($mouseLocation, $mouseLocationSet)) {
                continue;
            }
            $minCost = INF;
            $minPrevNode = $start;
            // $prevLocation = k
            foreach ($mouseLocationSet as $prevLocation) {
                // Calculate C(i, k)
                $prevToCurrent = count((new AStar($map, $prevLocation, $mouseLocation))->run()) - 2;
                if ($prevToCurrent < 0) {
                    $prevToCurrent = INF;
                }
                // Calculate g(k, S - {k})
                $minSetToCurrent = getCost($mouseLocationSet, $prevLocation, $minCostDp);
                $cost = $prevToCurrent + $minSetToCurrent;
                if ($cost < $minCost) {
                    $minCost = $cost;
                    $minPrevNode = $prevLocation;
                }
            }

            if (empty($mouseLocationSet)) {
                $minCost = 0;
            }
            $index = getIndex($mouseLocation, $mouseLocationSet);
            $minCostDp[$index] = $minCost;
            $parent[$index] = $minPrevNode;
        }
    }
    $min = INF;
    $prevLocation = [];
    $allMouseLocations = end($mouseLocationSets);
    // Calculate Final g(i, S), where i = start and S = all mouse locations
    foreach ($mouseLocations as $mouseLocation) {
        $prevToCurrent = count((new AStar($map, $mouseLocation, $start))->run()) - 2;
        if ($prevToCurrent < 0) {
            $prevToCurrent = INF;
        }
        $minSetToCurrent = getCost($allMouseLocations, $mouseLocation, $minCostDp);
        $cost = $prevToCurrent + $minSetToCurrent;
        if ($cost < $min) {
            $min = $cost;
            $prevLocation = $mouseLocation;
        }
    }

    if ($min === INF) {
        print_r('無解');
    }

    $parent[getIndex($start, $allMouseLocations)] = $prevLocation;

    // Extract costs and mouse names from each minimum cost step
    $startValue = end($parent);
    reset($parent);
    while ($startValue) {
        $key = array_search($startValue, $allMouseLocations);
        unset($allMouseLocations[$key]);
        $allMouseLocations = array_values($allMouseLocations);
        $startKey = getIndex($startValue, $allMouseLocations);
        $cost = $min - $minCostDp[$startKey];
        $min = $minCostDp[$startKey];
        if (($mouseName = array_search($startValue, $mouseLocations)) !== false) {
            print_r($cost . $mouseName);
        }
        $startValue = $parent[$startKey];
    }
    print_r(PHP_EOL);
}
