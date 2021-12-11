<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\AbstractFilter;
use Doctrine\ODM\MongoDB\Aggregation\Builder;
use Exception;
use Symfony\Component\PropertyInfo\Type;

final class PropertiesFilter extends AbstractFilter
{
    public function filterProperty(string $property, $value, Builder $aggregationBuilder, string $resourceClass, string $operationName = null, array &$context = [])
    {
        // otherwise filter is applied to order and page as well
        
        if ($property !== 'property') {
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
                    ->field('properties')
                    ->elemMatch([
                        'name' => $propertyName,
                        'extendValues.numValue' => [
                            '$gt' =>  (int)$minVal
                        ]
                    ]);
            }else{
                $aggregationBuilder
                    ->match()
                    ->field('properties')
                    ->elemMatch([
                        'name' => $propertyName,
                        'extendValues.numValue' => [
                            '$gt' =>  (int)$minVal,
                            '$lte' => (int)$maxVal
                        ]
                    ]);
            }
        }
        

    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
  
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