<?php
namespace Alsar\Monolog\Processor;

use Symfony\Component\HttpFoundation\RequestStack;
use phpbrowscap\Browscap;

class BrowscapProcessor
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var Browscap
     */
    protected $browscap;

    /**
     * @param RequestStack $stack
     * @param Browscap     $browscap
     */
    public function __construct(RequestStack $stack, Browscap $browscap)
    {
        $this->requestStack = $stack;
        $this->browscap     = $browscap;
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

        $uaString = $request->server->get('HTTP_USER_AGENT');

        $browserInfo = $this->browscap->getBrowser($uaString);

        $record['extra']['ua']['browser'] = $browserInfo->Browser;
        $record['extra']['ua']['version'] = $browserInfo->Version;
        $record['extra']['ua']['platform'] = $browserInfo->Platform;

        return $record;
    }
}