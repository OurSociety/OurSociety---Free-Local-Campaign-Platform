<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Element\Layout;

use OurSociety\TestSuite\Behat\Page\Element\Element;

class Flash extends Element
{
    protected $selector = '#toast-container';

    public function getStyle(): string
    {
        return str_replace('toast toast-', '', $this->findByCss('.toast')->getAttribute('class'));
    }

    public function getMessage(): string
    {
        $message = $this->findByCss('.toast-message');

        return trim($message->getText(), '× ');
    }

    public function close(): void
    {
        $this->findByCss('.toast')->click();
        $this->waitUntilLastElementIsRemoved();
    }
}
