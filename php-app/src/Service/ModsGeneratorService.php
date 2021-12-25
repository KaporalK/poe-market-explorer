<?php

namespace App\Service;

use Exception;

class ModsGeneratorService
{

    public static function handleMods(string $mod, string $slug, ?string $type = null)
    {
        //maybe something to do here ????
        return self::handleClassicMod($mod, $slug, $type);
    }

    public static function handleModsExt(string $mod, string $type)
    {
        //maybe something to do here ????
        preg_match_all('/[\d]+\.[\d]+|[\d]+/u', $mod, $matche);

        if (!empty($matche[0])) {
            return self::handleClassicModExt($mod, $type);
        } else {
            return self::handleModExtWithoutValue($mod, $type);
        }
    }

    public static function makeSlugForMod(string $mod)
    {
        return  preg_replace(['/\%/', '/\+/'], '', preg_replace('/\s+/u', '_', preg_replace('/[\d]+\.[\d]+|[\d]+/u', 'X', $mod)));
    }

    public static function handleClassicMod(string $mod, string $slug, string $type)
    {
        preg_match_all('/[\d]+\.[\d]+|[\d]+/u', $mod, $matche);

        $modDatas = [
            'slug' => $slug,
            'text' => preg_replace('/[\d]+\.[\d]+|[\d]+/u', 'X', $mod),
            'replace' => preg_replace('/[\d]+\.[\d]+|[\d]+/u', '%s', $mod),
            'nbValue' => count($matche[0]),
            'type' => [$type],
        ];
        return $modDatas;
    }

    public static function handleClassicModExt(string $mod, string $type)
    {
        preg_match_all('/[\d]+\.[\d]+|[\d]+/u', $mod, $matche);
        $modDatas = [
            'text' => $mod,
            'slug' => self::makeSlugForMod($mod),
            'numValue' => $matche[0],
            'average' => array_sum($matche[0]) / count($matche[0]),
            'type' => [$type],
            'tier' => 0,
        ];
        return $modDatas;
    }

    public static function handleModExtWithoutValue(string $mod, string $type)
    {
        $modDatas = [
            'text' => $mod,
            'slug' => self::makeSlugForMod($mod),
            'numValue' => null,
            'average' => null,
            'type' => [$type],
            'tier' => 1,
        ];
        return $modDatas;
    }
}
