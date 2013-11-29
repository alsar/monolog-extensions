<?php
namespace Alsar\Monolog\Processor;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProcessor
{
    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param array $record
     *
     * @return string
     */
    public function processRecord(array $record)
    {
        $token = $this->securityContext->getToken();

        $record['extra']['user'] = 'anonymous';

        if ($token instanceof TokenInterface) {
            $user = $token->getUser();
            if ($user instanceof UserInterface) {
                $record['extra']['user'] = $user->getUsername();
            }
        }

        return $record;
    }
}