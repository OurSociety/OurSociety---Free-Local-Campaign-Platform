<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Field;

use Cake\I18n\Date;
use DateTimeInterface;

final class DateField extends Field
{
    public const FORMAT_MONTH = 'month';

    /**
     * @var string|null
     */
    private $emptyPlaceholder;

    /**
     * @var string
     */
    private $format;

    public function getDate(): ?DateTimeInterface
    {
        return $this->getValue();
    }

    public function setEmptyPlaceholder(string $text): self
    {
        $this->emptyPlaceholder = $text;

        return $this;
    }

    public function getFormattedDate(): string
    {
        /** @var Date $date */
        $date = $this->getDate();

        if ($date === null) {
            return $this->getEmptyPlaceholder();
        }

        return $this->format !== null
            ? $date->format($this->format)
            : $date->nice();
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    protected function getEmptyPlaceholder(): string
    {
        return $this->emptyPlaceholder ?? 'N/A';
    }
}
