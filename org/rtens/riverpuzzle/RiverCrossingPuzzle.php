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
        return $this->solveState($this->getStart(), array($this->getStart()));
    }

    private function solveState($state, $previousStates) {

        foreach ($this->getMoves() as $object) {
            $nextState = $this->move($object, $state);

            if ($nextState == $this->getEnd()) {
                $this->logger->logMove($object, $nextState);
                return true;
            } else if (!in_array($nextState, $previousStates) && $this->isValid($nextState)) {
                $this->logger->logMove($object, $nextState);
                $previousStates[] = $nextState;

                if ($this->solveState($nextState, $previousStates)) {
                    return true;
                }
            }
        }

        $this->logger->undoMove();
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
        $moves = array();
        foreach ($this->objects as $object) {
            $moves[] = $object;
        }
        $moves[] = self::NOTHING;
        return $moves;
    }
}
