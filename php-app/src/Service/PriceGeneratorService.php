<?php

namespace App\Service;

use App\Entity\Mongo\Embedded\PriceExt;
use Exception;

class PriceGeneratorService
{

    public function handleNoteToPrice(string $note): PriceExt
    {
        $price = new PriceExt;

        $price->setText($note);
        
        if(strpos($note, '~price')){
            $price->setIsExact(true);
        }elseif(strpos($note, '~b/o')){
            $price->setIsExact(false);
        }
        $expl = explode(' ', $note);

        preg_match_all('/[\d]+\.[\d]+|[\d]+/u', $note, $matche);
        if(count($matche[0]) === 1){
            $price->setValue($matche[0][0]);
        }
        if(count($expl) === 3){
            $price->setUnit($expl[2]);
            $price->setValue($expl[1]);
        }

        return $price;
    }
}
