<?php

namespace Jerodev\LaraFontAwesome\Models;

class Icon
{
    /** @var string */
    private $name;

    /** @var string */
    private $library;

    /** @var string */
    private $cssClasses;

    public function __construct(string $name, string $library = 'null')
    {
        $this->name = $name;
        $this->library = $library;
        $this->cssClasses = 'null';
    }

    /**
     * Indicates whether the icon contains any variables or expressions.
     * The check is very basic, but matches most used use-cases.
     * Might need some improvement in the future.
     *
     * @return bool
     */
    public function isStatic(): bool
    {
        $values = [
            $this->name,
            $this->library,
            $this->cssClasses,
        ];
        foreach ($values as $value) {
            if ($value[0] === '$') {
                return false;
            }

            if ($value[0] === '"') {

                // $ between " not preceded by \
                $pos = \strpos('$', $value);
                if ($pos !== false && $value[$pos - 1] !== '\\') {
                    return false;
                }
            }
        }

        return true;
    }

    public function setLibrary(string $library): void
    {
        if ($library) {
            $this->library = $library;
        }
    }

    public function setCssClasses(string $cssClasses): void
    {
        if ($cssClasses) {
            $this->cssClasses = $cssClasses;
        }
    }

    public function getName(bool $clean = false): ?string
    {
        if ($clean) {
            return $this->cleanValue($this->name);
        }

        return $this->name;
    }

    public function getLibrary(bool $clean = false): ?string
    {
        if ($clean) {
            return $this->cleanValue($this->library);
        }

        return $this->library;
    }

    public function getCssClasses(bool $clean = false): ?string
    {
        if ($clean) {
            return $this->cleanValue($this->cssClasses);
        }

        return $this->cssClasses;
    }

    private function cleanValue(string $value): ?string
    {
        $value = \trim($value, '\'"');

        if ($value === 'null' || \strlen($value) === 0) {
            return null;
        }

        return $value;
    }
}
