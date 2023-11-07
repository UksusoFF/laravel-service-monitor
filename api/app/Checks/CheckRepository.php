<?php

declare(strict_types=1);

namespace App\Checks;

class CheckRepository
{
    protected array $registered = [
        MegafonCheck::class,
    ];

    /**
     * @return \App\Checks\CheckInterface[]
     */
    public function all(): array
    {
        return array_filter(array_map(function(string $class) {
            /** @var \App\Checks\CheckInterface $instance */
            $instance = app($class);
            return $instance->isEnabled() ? $instance : null;
        }, $this->registered));
    }
}
