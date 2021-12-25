<?php

namespace App\Entity\Mongo\Embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class ExtendValue
 * @package App\Entity\Mongo\Embedded
 * @MongoDB\EmbeddedDocument
 */
class ExtendValue
{

    /**
     * @MongoDB\Field(type="float")
     * @Groups({"item_get"})
     */
    private ?float $numValue = null;

    /**
     * @MongoDB\Field(type="float")
     * @Groups({"item_get"})
     */
    private ?float $minValue = null;

    /**
     * @MongoDB\Field(type="float")
     * @Groups({"item_get"})
     */
    private ?float $maxValue = null;

    /**
     * @MongoDB\Field(type="float")
     * @Groups({"item_get"})
     */
    private ?float $average = null;

    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private ?int $type = null;

  
    public function getNumValue(): ?float
    {
        return $this->numValue;
    }

    public function setNumValue(?float $numValue)
    {
        $this->numValue = $numValue;
    }
 
    public function getMinValue(): ?float
    {
        return $this->minValue;
    }

    public function setMinValue(?float $minValue)
    {
        $this->minValue = $minValue;
    }

    public function getMaxValue(): ?float
    {
        return $this->maxValue;
    }

    public function setMaxValue(?float $maxValue)
    {
        $this->maxValue = $maxValue;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type)
    {
        $this->type = $type;
    }

    public function getAverage(): ?float
    {
        return $this->average;
    }

    public function setAverage(?float $average): self
    {
        $this->average = $average;

        return $this;
    }
}