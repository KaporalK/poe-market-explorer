<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\AbstractFilter;
use Doctrine\ODM\MongoDB\Aggregation\Builder;
use Exception;
use Symfony\Component\PropertyInfo\Type;

final class ItemNameFilter extends AbstractFilter
{
    public function filterProperty(string $property, $value, Builder $aggregationBuilder, string $resourceClass, string $operationName = null, array &$context = [])
    {
        // otherwise filter is applied to order and page as well
        if ($property !== 'itemName' || !is_string($value)) {
            return;
        }
        // var_dump($property, $value);die;

        $aggregationBuilder
            ->match()
            ->addOr(
                ['name' => ['$regex' => $value, '$options' => 'i']],
                ['baseType' => ['$regex' => $value, '$options' => 'i']]
            );
    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        $description = [];
        $description['itemName'] = [
            'property' => 'itemName',
            'type' => Type::BUILTIN_TYPE_STRING,
            'required' => false,
            'swagger' => [
                'description' => 'filter using itemName=myName',
                'name' => 'itemName filter',
                'type' => 'string',
            ],
        ];

        return $description;
    }
}
