<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\View\Cell;

use Cake\TestSuite\TestCase;
use OurSociety\View\Cell\Common\QuestionCell;
use Cake\Network\Request;
use Cake\Network\Response;

/**
 * OurSociety\View\Cell\Common\QuestionCell Test Case
 */
class QuestionCellTest extends TestCase
{

    /**
     * Request mock
     *
     * @var \Cake\Network\Request|\PHPUnit_Framework_MockObject_MockObject
     */
    public $request;

    /**
     * Response mock
     *
     * @var \Cake\Http\Response|\PHPUnit_Framework_MockObject_MockObject
     */
    public $response;

    /**
     * Test subject
     *
     * @var \OurSociety\View\Cell\Common\QuestionCell
     */
    public $Question;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->request = $this->getMockBuilder(Request::class)->getMock();
        $this->response = $this->getMockBuilder(Response::class)->getMock();
        $this->Question = new QuestionCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Question);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
