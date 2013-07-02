<?php
namespace org\rtens\riverpuzzle;
 
class RiverCrossingPuzzle {

    const FARMER = '!';

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

        foreach ($this->objects as $object) {
            $state = $this->move($object, $state);
            $this->logger->logMove($object, $state);
        }
        return true;
    }

    private function move($object, $state) {
        $state[self::FARMER] = !$state[self::FARMER];
        $state[$object] = !$state[$object];
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
}
