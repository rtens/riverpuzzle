<?php
namespace org\rtens\riverpuzzle;
 
class Test extends \PHPUnit_Framework_TestCase {

    /** @var Logger */
    public $logger;

    function testCrossRiver() {
        $puzzle = new RiverCrossingPuzzle($this->logger);
        $puzzle->addObject('a');
        $solved = $puzzle->solve();

        $this->assertTrue($solved);
        $this->assertEquals('a', $this->logger->getMovesAsString());
    }

    protected function setUp() {
        parent::setUp();
        $this->logger = new Logger();
    }

}
