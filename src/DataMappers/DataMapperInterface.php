<?php
namespace Dobrik\LaravelEasyForm\DataMappers;

interface DataMapperInterface
{
    public function __construct($dataSource);

    public function mapToForm(): array;

    public function mapToSource(array $data);
}