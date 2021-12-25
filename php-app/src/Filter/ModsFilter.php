<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\AbstractFilter;
use Doctrine\ODM\MongoDB\Aggregation\Builder;
use Exception;
use Symfony\Component\PropertyInfo\Type;

final class ModsFilter extends AbstractFilter
{
    public function filterProperty(string $property, $value, Builder $aggregationBuilder, string $resourceClass, string $operationName = null, array &$context = [])
    {
        // otherwise filter is applied to order and page as well
        
        if ($property !== 'mods') {
            return;
        }
        // var_dump($property, $value);die;
        foreach($value as $propertyName => $val){
            if(!is_string($propertyName)){
                break;
            }
            $explodVal = explode(',', $val);
            if(count($explodVal) === 2){
                $minVal = $explodVal[0];
                $maxVal = $explodVal[1];
            }elseif(count($explodVal) === 1){
                $minVal = $explodVal[0];
                $maxVal = null;
            }else{
                throw new Exception('Wrong value used for filter property['.$propertyName.']');
            }
            if($maxVal === null){

                $aggregationBuilder
                    ->match()
                    ->field('modExts')
                    ->elemMatch([
                        'slug' => ['$regex' => '.*'.$propertyName.'.*'],
                        'average' => [
                            '$gt' =>  (float)$minVal
                        ]
                    ]);

            }else{
                $aggregationBuilder
                    ->match()
                    ->field('modExts')
                    ->elemMatch([
                        'slug' => ['$regex' =>'.*'.$propertyName.'.*'],
                        'average' => [
                            '$gt' =>  (float)$minVal,
                            '$lte' => (float)$maxVal
                        ]
                    ]);
            }
        }
        

    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
  
        $description = [];
        $description['mods[]'] = [
            'property' => 'mods[]',
            'type' => Type::BUILTIN_TYPE_ARRAY,
            'required' => false,
            'swagger' => [
                'description' => 'filter using mods["ModsSlug"]=minValue or mods["ModsSlug"]=minValue,maxValue',
                'name' => 'Mods filter',
                'type' => 'increased_Atack_Speed/increased_Projectile_Speed/...',
                'style' => 'deepObject'
            ],
            'is_collection' => true
        ];

        return $description;
    }
}