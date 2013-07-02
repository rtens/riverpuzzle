<?php
namespace org\rtens\riverpuzzle;

class Test extends \PHPUnit_Framework_TestCase {

    function testCrossRiverWithOne() {
        $this->givenAnObject('a');
        $this->whenISolveThePuzzle();

        $this->thenItShouldFindASolution();
        $this->thenTheMovesShouldBe('a');
    }

    function testCrossRiverWithTwo() {
        $this->givenAnObject('a');
        $this->givenAnObject('b');

        $this->whenISolveThePuzzle();

        $this->thenItShouldFindASolution();
        $this->thenTheMovesShouldBe('a b');
    }

    function testConstraintsWithThree() {
        $this->givenAnObject('a');
        $this->givenAnObject('b');
        $this->givenAnObject('c');
        $this->given_WouldEat('b', 'c');

        $this->whenISolveThePuzzle();

        $this->thenItShouldFindASolution();
        $this->thenTheMovesShouldBe('b a c');
    }

    function testOriginalPuzzle() {
        $this->givenAnObject('g');
        $this->givenAnObject('w');
        $this->givenAnObject('s');
        $this->given_WouldEat('w', 'g');
        $this->given_WouldEat('g', 's');

        $this->whenISolveThePuzzle();

        $this->thenItShouldFindASolution();
        $this->thenTheMovesShouldBe('g wgs g');
    }

    function testImpossible() {
        $this->givenAnObject('a');
        $this->givenAnObject('b');
        $this->givenAnObject('c');
        $this->given_WouldEat('a', 'b');
        $this->given_WouldEat('a', 'c');
        $this->given_WouldEat('b', 'c');

        $this->whenISolveThePuzzle();

        $this->thenItNotShouldFindASolution();
    }

    function testImpossibleComplex() {
        $this->givenAnObject('a');
        $this->givenAnObject('b');
        $this->givenAnObject('c');
        $this->givenAnObject('d');
        $this->given_WouldEat('a', 'b');
        $this->given_WouldEat('b', 'c');
        $this->given_WouldEat('b', 'd');


        $this->whenISolveThePuzzle();

        $this->thenItNotShouldFindASolution();
    }

    /** @var Logger */
    public $logger;

    /** @var RiverCrossingPuzzle */
    public $puzzle;

    /** @var boolean|null */
    public $solved;

    protected function setUp() {
        parent::setUp();
        $this->logger = new Logger();
        $this->puzzle = new RiverCrossingPuzzle($this->logger);
    }

    private function givenAnObject($name) {
        $this->puzzle->addObject($name);
    }

    private function whenISolveThePuzzle() {
        $this->solved = $this->puzzle->solve();
    }

    private function thenItShouldFindASolution() {
        $this->assertTrue($this->solved);
    }

    private function thenItNotShouldFindASolution() {
        $this->assertFalse($this->solved);
    }

    private function thenTheMovesShouldBe($string) {
        $this->assertEquals($string, $this->logger->getMovesAsString());
    }

    private function given_WouldEat($name1, $name2) {
        $this->puzzle->addConstraint($name1, $name2);
    }

    private function visualizeMoves() {
        echo PHP_EOL . $this->logger->getVisualizedMoves();
    }

}
