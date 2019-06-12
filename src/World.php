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
            $dup = [];
            foreach ($this->map as $x => &$row) {
                foreach ($row as $y => &$cell) {
                    $neighbors = $cell->neighbors();
                    $dup[$x][$y] = $neighbors;
                    if ($cell->isLive() && ($neighbors < 2 || $neighbors > 3)) {
                        $cell->toggle();
                    } elseif (! $cell->isLive() && $neighbors == 3) {
                        $cell->toggle();
                    }
                }
            }

            // $this->print($dup);

            foreach ($this->map as $x => &$row) {
                foreach ($row as $y => &$cell) {
                    $cell->sync();
                }
            }

            $this->print($this->map);
            sleep(1);
        }
    }

    private function print($map)
    {
        system('clear');
        foreach ($map as $row) {
            foreach ($row as $cell) {
                print " $cell ";
            }
            print "\n";
        }
    }
}
