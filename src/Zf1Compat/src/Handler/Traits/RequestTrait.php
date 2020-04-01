<?php
namespace Zf1Compat\Handler\Traits;

use Psr\Http\Message\ServerRequestInterface;

trait RequestTrait
{
    /**
     * Is the request a Javascript XMLHttpRequest?
     *
     * Should work with Prototype/Script.aculo.us, possibly others.
     *
     * @param ServerRequestInterface $request
     *
     * @return bool
     */
    public function isXmlHttpRequest(ServerRequestInterface $request)
    {
        $header = $request->getHeader('X-Requested-With');
        return isset($header[0]) && $header[0] == 'XMLHttpRequest';
    }
}
