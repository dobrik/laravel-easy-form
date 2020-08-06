<?php

namespace Dobrik\LaravelEasyForm\DataMappers;

use Dobrik\LaravelEasyForm\Exceptions\InvalidDataSourceException;
use Illuminate\Database\Eloquent\Model;

class EloquentDataMapper implements DataMapperInterface
{
    private $dataSource;

    public function __construct($dataSource)
    {
        if (!$dataSource instanceof Model) {
            throw new InvalidDataSourceException(sprintf('Data source should be instance of "Illuminate\Database\Eloquent\Model", "%s" given.', get_class($dataSource)));
        }
        $this->dataSource = $dataSource;
    }

    public function mapToForm(): array
    {
        return $this->dataSource->toArray();
    }

    public function mapToSource(array $data)
    {
        $this->dataSource->fill($data);
    }
}