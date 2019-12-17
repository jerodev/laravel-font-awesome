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

            $in_double_quote_string = false;
            $in_string = false;
            $last_char = null;
            for ($i = 0; $i < \strlen($value); $i++) {
                $char = $value[$i];

                switch ($char) {
                    case '"':
                        if (! $in_string) {
                            $in_double_quote_string = ! $in_double_quote_string;
                        }
                        break;

                    case '\'':
                        if (! $in_double_quote_string) {
                            $in_string = ! $in_string;
                        }
                        break;

                    case '$':
                        if (! $in_string && ! $in_double_quote_string) {
                            return false;
                        }
                        if ($in_double_quote_string && $last_char !== '\\') {
                            return false;
                        }
                        break;
                }

                $last_char = $char;
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
