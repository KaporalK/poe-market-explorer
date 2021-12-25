<?php

namespace App\Service;

use Exception;
//todo add tag to all properties
class PropertiesGeneratorService
{

    public static function handlePropertiesByType(array $properties, int $type)
    {

        if (!in_array($type, [10]) && count($properties['values']) > 1) {
            var_dump('wtf by type');
            var_dump($properties);
            throw new Exception('wtf by type 2');
        }

        switch ($type) {
            case 1:
            case 5:
            case 13:
            case 14:
            case 16:
            case 17:
            case 18:
                return self::singleNbToIntProperties($properties);

            case 3:
            case 2:
            case 6:
            case 12:
            case 15:
                return self::addPercentToProperties($properties);

            case 9:
            case 11:
                return self::doubleNbToIntProperties($properties);

            case 10:
                return self::multipleValueDoubleToProperties($properties);

            case 4: // ??? check this
            case 24:
            case 25:
            case 26:
            case 32:
            case 27: // and this
            case 31: // and this
            case 34: // and this
            case 39: // and this
            case 50: // and this
            case 46: // and this
            case 47: // and this
            case 35: // and this
            case 40: // and this
            case 41: // and this
            case 42: // and this
            case 43: // and this
            case 45: // and this
            case 36: // and this
            case 37: // and this
            case 54: // and this
                return self::valueToProperties($properties);

            default:
                throw new Exception('Unhandle type :' . $type);
                break;
        }
    }

    public static function handleOtherProperties(array $properties)
    {

        if (strpos($properties['name'], ',') && empty($properties['values']) && $properties['displayMode'] === 0) {
            $tags = explode(',', $properties['name']);
            $properties = [];
            foreach ($tags as $tag) {
                $properties[] = [
                    'tag' => 'Gem tags',
                    'name' => trim($tag)
                ];
            }
            return $properties;
        } elseif (count($properties['values']) > 1) {
            ///TODO
            if (strpos('-', $properties['values'][0][0])){    
                return self::multipleValueDoubleToProperties($properties);
            }
            var_dump('todo handle other properties');           
            var_dump($properties['values']);
        }
        return $properties;
    }

    private static function singleNbToIntProperties(array $properties)
    {
        $newProperties = $properties;
        $newProperties['extendValues'] = [
            'numValue' => floatval($properties['values'][0][0]),
            'average' => floatval($properties['values'][0][0]),
            'type' => $properties['values'][0][1],
        ];
        return $newProperties;
    }

    private static function addPercentToProperties(array $properties)
    {
        $newProperties = $properties;
        $newProperties['extendValues'] = [
            'numValue' => floatval(trim($properties['values'][0][0], '+%')),
            'average' => floatval(trim($properties['values'][0][0], '+%')),
            'type' => $properties['values'][0][1],
        ];
        return $newProperties;
    }

    private static function doubleNbToIntProperties(array $properties)
    {
        $newProperties = $properties;
        $explodeValue = explode('-', $properties['values'][0][0]);
        $newProperties['extendValues'] = [
            'minValue' => floatval($explodeValue[0]),
            'maxValue' => floatval($explodeValue[1]),
            'average' => floatval($explodeValue[0]) + floatval($explodeValue[1]) / 2,
            'type' => $properties['values'][0][1],
        ];
        return $newProperties;
    }

    private static function multipleValueDoubleToProperties(array $properties)
    {
        $newProperties = $properties;
        foreach ($properties['values'] as $values) {
            $explodeValue = explode('-', $values[0]);
            $newProperties['extendValues'][] = [
                'minValue' => floatval($explodeValue[0]),
                'maxValue' => floatval($explodeValue[1]),
                'average' => floatval($explodeValue[0]) + floatval($explodeValue[1]) / 2,
                'type' => $values[1],
            ];
        }
        return $newProperties;
    }

    private static function valueToProperties(array $properties)
    {
        $newProperties = $properties;
        $newProperties['extendValues'] = [
            'value' => $properties['values'][0][0],
            'average' => $properties['values'][0][0],
            'type' => $properties['values'][0][1],
        ];
        return $newProperties;
    }
}
