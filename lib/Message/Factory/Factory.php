<?php

namespace ShortMessage\Message\Factory;

use ShortMessage\Message\Form\FormRequest;
use ShortMessage\Message\Request;
use ShortMessage\Message\RequestInterface;
use ShortMessage\Message\Response;

class Factory implements FactoryInterface
{
    public function createRequest($method = RequestInterface::METHOD_GET, $resource = '/', $host = null)
    {
        return new Request($method, $resource, $host);
    }

    public function createFormRequest($method = RequestInterface::METHOD_POST, $resource = '/', $host = null)
    {
        return new FormRequest($method, $resource, $host);
    }

    public function createResponse()
    {
        return new Response();
    }
}
