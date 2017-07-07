<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite;

trait ExceptionTrait
{
    /**
     * Expect exception class.
     *
     * Sets up PHPUnit to expect a given exception instance, if not null.
     *
     * @param \Exception|null $exception The expected exception, if any.
     * @return void
     * @throws \PHPUnit\Framework\Exception If exception message is not a string.
     */
    public function expectExceptionClass(\Exception $exception = null): void
    {
        if ($exception === null) {
            return;
        }

        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());
    }
}
