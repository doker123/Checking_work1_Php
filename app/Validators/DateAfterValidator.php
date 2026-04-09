<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class DateAfterValidator extends AbstractValidator
{
    protected string $message = 'Дата :field должна быть позже указанной даты';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return true;
        }
        
        $compareDate = $this->args[0] ?? null;
        if (!$compareDate) {
            return true;
        }
        
        $dateValue = strtotime($this->value);
        $dateCompare = strtotime($compareDate);
        
        return $dateValue && $dateCompare && $dateValue >= $dateCompare;
    }
}
