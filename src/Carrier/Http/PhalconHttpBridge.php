<?php


namespace Maleficarum\ContextTracing\Carrier\Http;

use Phalcon\Http\Request;

class PhalconHttpBridge implements HttpHeaderProvider
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->request->getHeaders();
    }
}