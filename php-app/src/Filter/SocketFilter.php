<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\AbstractFilter;
use Doctrine\ODM\MongoDB\Aggregation\Builder;
use Exception;
use Symfony\Component\PropertyInfo\Type;

//todo should be LinkedColor filter but idk how to do it
final class SocketFilter extends AbstractFilter
{
    public function filterProperty(string $property, $value, Builder $aggregationBuilder, string $resourceClass, string $operationName = null, array &$context = [])
    {
         // otherwise filter is applied to order and page as well
        if ($property !== 'socket') {
            return;
        }
        // var_dump($property, $value);die;
        foreach($value as $propertyName => $val){
           
        }
    }

    public function getDescription(string $resourceClass): array
    {
        $description = [];
        $description['socket[]'] = [
            'property' => 'socket[]',
            'type' => Type::BUILTIN_TYPE_ARRAY,
            'required' => false,
            'swagger' => [
                'description' => 'filter using socket["W/R/B/G"]=minValue',
                'name' => 'socket filter',
                'type' => 'Socket color',
                'style' => 'deepObject'
            ],
            'is_collection' => true
        ];

        return $description;
    }
}