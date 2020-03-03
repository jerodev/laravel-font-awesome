<?php

namespace Jerodev\LaraFontAwesome;

final class IconViewBoxCache
{
    /** @var int[][] */
    private $cache = [];

    public function get(string $icon, ?string $library = null): ?array
    {
        return $this->cache[$this->getIconId($icon, $library)] ?? null;
    }

    public function has(string $icon, ?string $library = null): bool
    {
        return $this->get($icon, $library) !== null;
    }

    public function getIconId(string $icon, ?string $library = null): string
    {
        return 'fa' . ($library ? $library[0] : null) . "-{$icon}";
    }

    public function put(string $icon, ?string $library, array $viewBox)
    {
        $this->cache[$this->getIconId($icon, $library)] = $viewBox;
    }
}
