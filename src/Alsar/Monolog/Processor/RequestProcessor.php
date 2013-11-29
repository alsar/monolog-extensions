<?php
namespace Alsar\Monolog\Processor;

use Symfony\Component\HttpFoundation\RequestStack;

class RequestProcessor
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @param RequestStack $stack
     */
    public function __construct(RequestStack $stack)
    {
        $this->requestStack = $stack;
    }

    /**
     * @param array $record
     *
     * @return string
     */
    public function processRecord(array $record)
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request == null) {
            return $record;
        }

        $record['extra']['uri'] = $request->getRequestUri();
        $record['extra']['clientIp'] = $request->getClientIp();
        $record['extra']['uaString'] = $request->server->get('HTTP_USER_AGENT');

        return $record;
    }
}