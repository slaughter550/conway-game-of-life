<?php

class Cell
{
    protected $live;

    protected $tempLive;

    protected $world;

    protected $x;

    protected $y;

    public function __construct($world, $x, $y, $live)
    {
        $this->world = $world;
        $this->live = $this->tempLive = $live;
        $this->x = $x;
        $this->y = $y;
    }

    public function isLive()
    {
        return $this->live;
    }

    public function neighbors()
    {
        $neighbors = [];

        $neighbors[] = $this->getNeighbor($this->x - 1, $this->y - 1);
        $neighbors[] = $this->getNeighbor($this->x - 1, $this->y);
        $neighbors[] = $this->getNeighbor($this->x - 1, $this->y + 1);

        $neighbors[] = $this->getNeighbor($this->x, $this->y - 1);
        $neighbors[] = $this->getNeighbor($this->x, $this->y + 1);

        $neighbors[] = $this->getNeighbor($this->x + 1, $this->y - 1);
        $neighbors[] = $this->getNeighbor($this->x + 1, $this->y);
        $neighbors[] = $this->getNeighbor($this->x + 1, $this->y + 1);

        return count(array_filter($neighbors, function ($cell) {
            return $cell && $cell->isLive();
        }));
    }

    public function sync()
    {
        $this->live = $this->tempLive;
    }

    public function toggle()
    {
        $this->tempLive = ! $this->live;
    }

    private function getNeighbor($x, $y)
    {
        return isset($this->world->map[$x][$y]) ? $this->world->map[$x][$y] : null;
    }

    public function __toString()
    {
        return $this->live ? 'X': ' ';
    }
}
