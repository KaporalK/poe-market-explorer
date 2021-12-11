<?php

/**
 * Created by PhpStorm.
 * User: KaporalK
 * Date: 01/06/2019
 * Time: 21:06
 */

namespace App\Entity\Mongo;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Mods
 * @package App\Entity\Mongo
 * @MongoDB\Document
 * @ApiResource(
 *     itemOperations={
 *          "get"
 *     },
 *     collectionOperations={
 *          "get"
 *     }
 * )
 * Class Object
 */
class Mods
{
    /**
     * @MongoDB\Id(strategy="NONE", type="string")
     */
    private string $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private string $text;

    /**
     * @MongoDB\Field(type="string")
     */
    private string $replace;

    /**
     * @MongoDB\Field(type="string")
     */
    private string $slug;

    /**
     * @MongoDB\Field(type="int")
     */
    private string $nbValue;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
    
    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function getReplace(): string
    {
        return $this->replace;
    }

    public function setReplace(string $replace)
    {
        $this->replace = $replace;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;

        return $this;
    }

    public function getNbValue(): string
    {
        return $this->nbValue;
    }

    public function setNbValue(string $nbValue)
    {
        $this->nbValue = $nbValue;

        return $this;
    }
}
