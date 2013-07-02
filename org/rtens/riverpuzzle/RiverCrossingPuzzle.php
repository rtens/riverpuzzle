<?php
namespace org\rtens\riverpuzzle;
 
class RiverCrossingPuzzle {

    const FARMER = '!';

    const NOTHING = ' ';

    public $constraints = array();

    private $objects = array();

    /** @var Logger */
    private $logger;

    function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    public function addObject($id) {
        $this->objects[] = $id;
    }

    public function addConstraint($id1, $id2) {
        $this->constraints[] = array($id1, $id2);
    }

    public function solve() {
        return $this->solveState($this->getStart(), array());
    }

    private function solveState($state, $previousStates) {
        if ($state == $this->getEnd()) {
            return true;
        } else if (!$this->isValid($state)) {
            return false;
        } else if (in_array($state, $previousStates)) {
            return false;
        }

        $previousStates[] = $state;

        foreach ($this->getMoves() as $object) {
            if ($this->canMove($object, $state)) {
                continue;
            }

            if ($this->solveState($this->move($object, $state), $previousStates)) {
                return true;
            }
            $this->logger->undoMove();
        }

        return false;
    }

    private function canMove($object, $state) {
        return $object != self::NOTHING && $state[$object] != $state[self::FARMER];
    }

    private function move($object, $state) {
        if ($object != self::NOTHING) {
            $state[$object] = !$state[$object];
        }
        $state[self::FARMER] = !$state[self::FARMER];

        $this->logger->logMove($object, $state);

        return $state;
    }

    private function isValid($state) {
        foreach ($this->constraints as $constraint) {
            if ($state[$constraint[0]] == $state[$constraint[1]] && $state[$constraint[0]] != $state[self::FARMER]) {
                return false;
            }
        }
        return true;
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
        $moves = array(self::NOTHING);
        foreach ($this->objects as $object) {
            $moves[] = $object;
        }
        return $moves;
    }
}
