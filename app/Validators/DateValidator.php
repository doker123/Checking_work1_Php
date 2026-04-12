<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class DateValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть корректной датой в формате YYYY-MM-DD';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return true;
        }
        
        $d = \DateTime::createFromFormat('Y-m-d', $this->value);
        return $d && $d->format('Y-m-d') === $this->value;
    }
}
