<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class EmailValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть корректным email-адресом';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return true;
        }
        
        return filter_var($this->value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
