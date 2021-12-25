<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\AbstractFilter;
use Doctrine\ODM\MongoDB\Aggregation\Builder;
use Exception;
use Symfony\Component\PropertyInfo\Type;

final class SocketFilter extends AbstractFilter
{
    public function filterProperty(string $property, $value, Builder $aggregationBuilder, string $resourceClass, string $operationName = null, array &$context = [])
    {
        
       //todo
        
        

    }

    public function getDescription(string $resourceClass): array
    {
  
        //todo
        $description = [];
        $description['property[]'] = [
            'property' => 'property[]',
            'type' => Type::BUILTIN_TYPE_ARRAY,
            'required' => false,
            'swagger' => [
                'description' => 'filter using property["PropertyName"]=minValue or property["PropertyName"]=minValue,maxValue',
                'name' => 'Property filter',
                'type' => 'Armour/Evasion/etc',
                'style' => 'deepObject'
            ],
            'is_collection' => true
        ];

        return $description;
    }
}