<?php

namespace Jerodev\LaraFontAwesome\Models;

use Illuminate\Container\Container;
use Illuminate\View\Engines\FileEngine;
use Illuminate\View\View;

/**
 * This DummyView prevents Laravel from creating a rendered blade file for each icon used.
 */
final class DummyView extends View
{
    public function __construct(string $renderedView)
    {
        parent::__construct(
            Container::getInstance()->make('view'),
            new FileEngine(),
            $renderedView,
            ''
        );
    }

    public function render(?callable $callback = null)
    {
        return $this->view;
    }
}
