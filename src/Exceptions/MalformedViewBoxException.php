<?php

namespace Jerodev\LaraFontAwesome\Exceptions;

use Exception;

final class MalformedViewBoxException extends Exception
{
    public function __construct(string $icon, $viewBox)
    {
        parent::__construct("Receive a mallformed viewbox for icon '$icon'. Expected int[4], but got \"" . \json_encode($viewBox) . '".');
    }
}
