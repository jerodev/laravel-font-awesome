<?php

namespace Jerodev\LaraFontAwesome\Middleware;

class InjectStyleSheet
{
    public function terminate($request, $response)
    {
        if (
            ($response->headers->has('Content-Type') && strpos($response->headers->get('Content-Type'), 'html') === false)
            || $request->getRequestFormat() !== 'html'
            || $response->getContent() === false
            || $request->isXmlHttpRequest()
        ) {
            return $response;
        }

        return $this->injectStyleSheet($response);
    }

    private function injectStyleSheet($response)
    {
        $content = $response->getContent();
        $content = str_replace('</head>', '<link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@5.9.0/css/svg-with-js.min.css" /></head>', $content);
        $response->setContent($content);

        return $response;
    }
}