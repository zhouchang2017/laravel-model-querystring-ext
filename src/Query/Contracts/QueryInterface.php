<?php

namespace Zc\Query\Contracts;


interface QueryInterface
{
    public function apply();

    public function getFieldsSearchable() :array ;

}