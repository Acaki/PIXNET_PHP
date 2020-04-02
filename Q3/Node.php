<?php

namespace Q3;

class Node
{
    public ?Node $parent;
    public array $position;
    public int $g;
    public int $h;
    public int $f;

    public function __construct($position = [0, 0], $parent = null)
    {
        $this->parent = $parent;
        $this->position = $position;
        $this->g = $this->h = $this->f = 0;
    }
}