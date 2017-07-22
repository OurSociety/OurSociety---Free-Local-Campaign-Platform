<?php
declare(strict_types=1);

namespace OurSociety\Test\TestCase\View\Cell;

use Cake\TestSuite\TestCase;
use OurSociety\View\Cell\Profile\PictureCell;
use Cake\Network\Request;
use Cake\Network\Response;

/**
 * OurSociety\View\Cell\Profile\PictureCell Test Case
 */
class PictureCellTest extends TestCase
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
     * @var \OurSociety\View\Cell\Profile\PictureCell
     */
    public $ProfilePicture;

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
        $this->ProfilePicture = new PictureCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProfilePicture);

        parent::tearDown();
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testDisplay(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
