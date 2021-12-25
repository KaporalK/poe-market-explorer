<?php

namespace App\Entity\Mongo\Embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class ExtendValue
 * @package App\Entity\Mongo\Embedded
 * @MongoDB\EmbeddedDocument
 */
class ModExt
{

    /**
     * @MongoDB\Field(type="string")
     * @Groups({"item_get"})
     */
    private string $text;
    /**
     * @MongoDB\Field(type="collection", nullable=true)
     * @Groups({"item_get"})
     */
    private array $numValue = [];

    /**
     * @MongoDB\Field(type="float")
     * @Groups({"item_get"})
     */
    private ?float $average = null;

    /**
     * @MongoDB\Field(type="collection", nullable=true)
     * @Groups({"item_get"})
     */
    private array $type = [];

    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private ?int $tier = null;
  
    public function getNumValue(): array
    {
        return $this->numValue;
    }

    public function setNumValue(array $numValue)
    {
        $this->numValue = $numValue;
    }

    public function getType(): array
    {
        return $this->type;
    }

    public function setType(array $type)
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

    public function getTier(): ?int
    {
        return $this->tier;
    }

    public function setTier(?int $tier): self
    {
        $this->tier = $tier;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}