<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class MinLengthValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать минимум :min символов';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return true;
        }
        
        $min = (int)($this->args[0] ?? 0);
        $this->messageKeys[':min'] = $min;
        $this->message = str_replace(':min', $min, $this->message);
        
        return mb_strlen($this->value) >= $min;
    }
}
