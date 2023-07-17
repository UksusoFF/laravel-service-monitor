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
        return array_map(function(string $class) {
            return app($class);
        }, $this->registered);
    }
}
