<?php
namespace org\rtens\riverpuzzle;
 
class Logger {

    private $moves = array();

    public function getMovesAsString() {
        $string = '';
        foreach ($this->moves as $move) {
            $string .= $move['object'];
        }
        return $string;
    }

    public function logMove($object, $state) {
        $this->moves[] = array(
            'object' => $object,
            'state' => $state
        );
    }

    public function getMoves() {
        return $this->moves;
    }

    public function getVisualizedMoves() {
        $string = '';
        foreach ($this->moves as $move) {
            $string .= $this->visualizeMove($move);
        }
        return $string;
    }

    private function visualizeMove($move) {
        $left = '';
        $right = '';
        foreach ($move['state'] as $object => $isLeft) {
            $left .= $isLeft ? $object : '_';
            $right .= !$isLeft ? $object : '_';
        }

        return $move['object'] . ' => ' . $left . '..' . $right . PHP_EOL;
    }

    public function undoMove() {
        array_pop($this->moves);
    }
}
