<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\AbstractFilter;
use Doctrine\ODM\MongoDB\Aggregation\Builder;
use Symfony\Component\PropertyInfo\Type;

final class RarityFilter extends AbstractFilter
{
    public function filterProperty(string $property, $value, Builder $aggregationBuilder, string $resourceClass, string $operationName = null, array &$context = [])
    {
        if ($property !== 'rarity' || !is_string($value)) {
            return;
        }
        // var_dump($property, $value);die;
        if ($value === "7") {
            $aggregationBuilder
                ->match()
                ->field('frameType')
                ->notIn([3]); //find relic rarity ? 3 might be only unique
        } else {
            $aggregationBuilder
                ->match()
                ->field('frameType')
                ->equals($value);
        }
    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        $description = [];
        $description['rarity'] = [
            'property' => 'rarity',
            'type' => Type::BUILTIN_TYPE_STRING,
            'required' => false,
            'swagger' => [
                'description' => 'filter using rarity={1,2,3,4,5,6}',
                'name' => 'rarity filter',
                'type' => 'string',
            ],
        ];

        return $description;
    }
}
