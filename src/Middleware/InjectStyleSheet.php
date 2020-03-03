<?php

namespace Jerodev\LaraFontAwesome\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyBaseResponse;

final class InjectStyleSheet
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (
            $response instanceof RedirectResponse
            || ($response->headers->has('Content-Type') && \strpos($response->headers->get('Content-Type'), 'html') === false)
            || $request->getRequestFormat() !== 'html'
            || $response->getContent() === false
            || $request->isXmlHttpRequest()
        ) {
            return $response;
        }

        return $this->injectStyleSheet($response);
    }

    private function injectStyleSheet(SymfonyBaseResponse $response)
    {
        $content = $response->getContent();
        $content = \str_replace('</head>', '<link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@5.12.1/css/svg-with-js.min.css"/></head>', $content);
        $response->setContent($content);

        return $response;
    }
}
