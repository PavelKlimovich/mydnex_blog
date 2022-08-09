<?php

namespace Src\Validator;

class Validator
{
    private array $params;

    public function __construct(array $params) {
        $this->params = $params;
    }

}
