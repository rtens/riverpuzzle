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
}
