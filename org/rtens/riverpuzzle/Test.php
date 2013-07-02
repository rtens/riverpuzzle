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
        $this->thenTheMovesShouldBe('ab');
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

    private function thenTheMovesShouldBe($string) {
        $this->assertEquals($string, $this->logger->getMovesAsString());
    }

}
