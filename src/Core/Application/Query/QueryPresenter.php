<?php

namespace Core\Application\Query;

interface QueryPresenter
{
    public function present(
        ?QueryResponse $response,
    ): void;
}