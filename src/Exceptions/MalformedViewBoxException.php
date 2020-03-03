<?php

namespace Jerodev\LaraFontAwesome\Exceptions;

use Exception;

final class MalformedViewBoxException extends Exception
{
    public function __construct($viewBox)
    {
        parent::__construct('ViewBox should be an array of 4 integers, got "' . \json_encode($viewBox) . '".');
    }
}
