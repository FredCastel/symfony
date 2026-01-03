<?php

namespace Core\Application\Query;

interface QueryHandler
{
    public function listenTo(): string;
    public function ask(QueryRequest $request, QueryPresenter $presenter): void;
}