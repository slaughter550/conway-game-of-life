<?php

require "Cell.php";

class World
{
    public $map = [];
    private $size;

    public function __construct($size)
    {
        $this->size = $size;
    }

    public function start()
    {
        $width = $height = $this->size;
        foreach (range(0, $width) as $x) {
            $this->map[$x] = [];

            foreach (range(0, $height) as $y) {
                $this->map[$x][$y] = (new Cell($this, $x, $y, (bool) random_int(0, 1)));
            }
        }

        while (true) {
            foreach ($this->map as $x => &$row) {
                foreach ($row as $y => &$cell) {
                    $neighbors = $cell->neighbors();
                    if ($cell->isLive() && ($neighbors < 2 || $neighbors > 3)) {
                        $cell->toggle();
                    } elseif (! $cell->isLive() && $neighbors == 3) {
                        $cell->toggle();
                    }
                }
            }

            foreach ($this->map as $x => &$row) {
                foreach ($row as $y => &$cell) {
                    $cell->sync();
                }
            }

            system('clear');
            print($this);
            sleep(1);
        }
    }

    public function __toString()
    {
        $string = "";
        foreach ($this->map as $row) {
            foreach ($row as $cell) {
                $string .= " $cell ";
            }
            $string .= "\n";
        }

        return $string;
    }
}
