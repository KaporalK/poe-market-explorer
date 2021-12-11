<?php

namespace App\Service;

use Exception;

class PropertiesGeneratorService {

    public static function handlePropertiesByType(array $properties, int $type){
        switch($type){
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
            case 10:
            case 11:
                return self::doubleNbToIntProperties($properties);
                
            case 24:
            case 25:
            case 26:
            case 32:
                return self::valueToProperties($properties);

            default:
                throw new Exception('Unhandle type :' . $type);
                break;
        }
    }
    
    private static function singleNbToIntProperties(array $properties){
        $newProperties = $properties;
        $newProperties['extendValues'] = [
            'numValue' => floatval($properties['values'][0]),
            'type' => $properties['values'][1],
        ];
        return $newProperties;
    }

    private static function addPercentToProperties(array $properties){
        $newProperties = $properties;
        $newProperties['extendValues'] = [
            'numValue' => floatval(trim($properties['values'][0], '+%')),
            'type' => $properties['values'][1],
        ];
        return $newProperties;
    }

    private static function doubleNbToIntProperties(array $properties){
        $newProperties = $properties;
        $explodeValue = explode('-', $properties['values'][0]);
        $newProperties['extendValues'] = [
            'minValue' => floatval($explodeValue[0]),
            'maxValue' => floatval($explodeValue[1]),
            'type' => $properties['values'][1],
        ];
        return $newProperties;
    }

    private static function valueToProperties(array $properties){
        $newProperties = $properties;
        $newProperties['extendValues'] = [
            'value' => $properties['values'][0],
            'type' => $properties['values'][1],
        ];
        return $newProperties;
    }

}