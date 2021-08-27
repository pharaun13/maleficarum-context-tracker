<?php


namespace Maleficarum\ContextTracing\Carrier\Http;


interface HttpHeaderProvider
{
    /**
     * @return array
     */
    public function getHeaders();
}