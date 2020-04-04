<?php

namespace Q3;

use SplPriorityQueue;

class CoordinatesPriorityQueue extends SplPriorityQueue
{
    public function compare($priority1, $priority2)
    {
        return $priority1 < $priority2 ? 1 : -1;
    }
}
