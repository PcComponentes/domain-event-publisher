<?php
declare(strict_types=1);

namespace PcComponentes\DomainEventPublisher\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\StackInterface;
use PcComponentes\DomainEventPublisher\DomainEventPublisher;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use PcComponentes\DomainEventPublisher\SubscriberExistException;
use PcComponentes\DomainEventPublisher\Subscriber\CollectInMemoryDomainEventSubscriber;

class AddSubscriberToDomainEventPublisherMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $domainEventPublisher = DomainEventPublisher::instance();

        try {
            $domainEventPublisher->subscribe(new CollectInMemoryDomainEventSubscriber());
        } catch (SubscriberExistException $exception) {
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
