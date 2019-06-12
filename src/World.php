<?php

require "Cell.php";

class World
{
    public $world = [];
    private $size;

    public function __construct($size)
    {
        $this->size = $size;
    }

    public function start()
    {
        $width = $height = $this->size;
        foreach (range(0, $width) as $x) {
            $this->world[$x] = [];

            foreach (range(0, $height) as $y) {
                $this->world[$x][$y] = (new Cell($this, $x, $y, (bool) random_int(0, 1)));
            }
        }

        while (true) {
            $dup = [];
            foreach ($this->world as $x => &$row) {
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

            foreach ($this->world as $x => &$row) {
                foreach ($row as $y => &$cell) {
                    $cell->sync();
                }
            }

            $this->print($this->world);
            sleep(1);
        }
    }

    private function print($world)
    {
        system('clear');
        foreach ($world as $row) {
            foreach ($row as $cell) {
                print " $cell ";
            }
            print "\n";
        }
    }
}
