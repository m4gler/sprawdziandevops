<?php

declare(strict_types=1);

namespace App;

final class App
{
    public function home(): string
    {
        return 'hello from php app';
    }

    public function health(): string
    {
        return 'ok';
    }
}
