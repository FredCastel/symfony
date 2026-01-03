<?php

namespace Core\Service\Bus\Query;

use Core\Application\Query\QueryPresenter;
use Core\Application\Query\QueryRequest;
use Core\Application\Query\QueryHandler;

class DispatcherQueryBus implements QueryBusMiddleware
{
    private iterable $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = [];
        foreach ($handlers as $value) {
            /** @var QueryHandler */
            $handler = $value;
            $this->handlers[$handler->listenTo()] = $handler;
        }
    }

    public function Dispatch(QueryRequest $request, QueryPresenter $presenter): void
    {
        $queryClass = get_class($request);
        if (!array_key_exists($queryClass, $this->handlers))
            throw new \LogicException("Handler for query $queryClass not found");
        /** @var QueryHandler */
        $handler = $this->handlers[$queryClass];

        $handler->ask($request, $presenter);
    }
}