<?php
namespace org\rtens\riverpuzzle;
 
class RiverCrossingPuzzle {

    const FARMER = '!';

    const NOTHING = ' ';

    private $objects = array();

    /** @var Logger */
    private $logger;

    function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    public function addObject($id) {
        $this->objects[] = $id;
    }

    public function solve() {
        $state = $this->getStart();
        $end = $this->getEnd();
        $moves = $this->getMoves();

        while ($state != $end) {
            foreach ($moves as $object) {
                $state = $this->move($object, $state);

                if ($state == $end) {
                    return true;
                }
            }
        }
        return false;
    }

    private function move($object, $state) {
        if ($object != self::NOTHING) {
            if ($state[$object] != $state[self::FARMER]) {
                return $state;
            }

            $state[$object] = !$state[$object];
        }
        $state[self::FARMER] = !$state[self::FARMER];

        $this->logger->logMove($object, $state);

        return $state;
    }

    private function getStart() {
        return $this->fillState(true);
    }

    private function getEnd() {
        return $this->fillState(false);
    }

    private function fillState($v) {
        $state = array(self::FARMER => $v);
        foreach ($this->objects as $object) {
            $state[$object] = $v;
        }
        return $state;
    }

    private function getMoves() {
        $moves = array();
        foreach ($this->objects as $object) {
            $moves[] = $object;
        }
        $moves[] = self::NOTHING;
        return $moves;
    }
}
