<?php

namespace Core\Service\Bus\Query;

use Core\Application\Query\QueryPresenter;
use Core\Application\Query\QueryRequest;

interface QueryBus
{
    public function Dispatch(QueryRequest $request, QueryPresenter $presenter): void;
}