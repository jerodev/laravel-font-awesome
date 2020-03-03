<?php

namespace Jerodev\LaraFontAwesome\Exceptions;

use Exception;

class UnknownIconException extends Exception
{
    public function __construct(string $icon, ?string $library = null)
    {
        $message = "Icon with name '{$icon}' could not be found";
        if ($library !== null) {
            $message .= " in library '{$library}'";
        }

        parent::__construct($message);
    }
}
