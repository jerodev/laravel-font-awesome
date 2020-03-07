<?php

namespace Jerodev\LaraFontAwesome\Tests;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jerodev\LaraFontAwesome\Middleware\InjectStyleSheet;
use Symfony\Component\HttpFoundation\Response as SymfonyBaseResponse;

final class MiddlewareTest extends TestCase
{
    /** @var InjectStyleSheet */
    private $middleware;

    public function setUp(): void
    {
        parent::setUp();

        $this->middleware = new InjectStyleSheet();
    }

    public function testDontInjectOnAjaxRequest(): void
    {
        $request = new Request();
        $request->headers->add(['X-Requested-With' => 'XMLHttpRequest']);
        $next = static function () {
            return new Response('<html><head></head></html>');
        };

        $response = $this->middleware->handle($request, $next);

        $this->assertStylesheetInjected($response, false);
    }

    public function testDontInjectOnRedirect(): void
    {
        $request = new Request();
        $next = static function () {
            return new RedirectResponse('https://www.deviaene.eu/');
        };

        $response = $this->middleware->handle($request, $next);

        $this->assertStylesheetInjected($response, false);
    }

    public function testInjectsStylesheetInHtmlResponse(): void
    {
        $request = new Request();
        $next = static function () {
            return new Response('<html><head></head></html>');
        };

        $response = $this->middleware->handle($request, $next);

        $this->assertStylesheetInjected($response);
    }

    private function assertStylesheetInjected(SymfonyBaseResponse $response, bool $injected = true): void
    {
        if ($injected) {
            $this->assertStringContainsString(
                '@fortawesome',
                $response->getContent()
            );
        } else {
            $this->assertStringNotContainsString(
                '@fortawesome',
                $response->getContent()
            );
        }
    }
}
