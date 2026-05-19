<?php

declare(strict_types=1);

namespace Tests;

use App\App;
use PHPUnit\Framework\TestCase;

final class AppTest extends TestCase
{
    public function testHomeReturnsWelcomeMessage(): void
    {
        $app = new App();

        self::assertSame('hello from php app', $app->home());
    }

    public function testHealthReturnsOk(): void
    {
        $app = new App();

        self::assertSame('ok', $app->health());
    }
}
