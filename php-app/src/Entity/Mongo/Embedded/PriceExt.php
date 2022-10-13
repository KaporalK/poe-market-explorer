<?php

namespace App\Entity\Mongo\Embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class PriceExt
 * @package App\Entity\Mongo\Embedded
 * @MongoDB\EmbeddedDocument
 */
class PriceExt
{

    /**
     * @MongoDB\Field(type="string")
     * @Groups({"item_get"})
     */
    private string $text;

    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private int $value;
    
    /**
     * @MongoDB\Field(type="string")
     * @Groups({"item_get"})
     */
    private string $unit;

    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private int $unitTier;

    /**
     * @MongoDB\Field(type="bool")
     * @Groups({"item_get"})
     */
    private bool $isExact;

    /**
     * Get the value of text
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @param string $text
     *
     * @return self
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of value
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param int $value
     *
     * @return self
     */
    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of unit
     *
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * Set the value of unit
     *
     * @param string $unit
     *
     * @return self
     */
    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get the value of unitTier
     *
     * @return int
     */
    public function getUnitTier(): int
    {
        return $this->unitTier;
    }

    /**
     * Set the value of unitTier
     *
     * @param int $unitTier
     *
     * @return self
     */
    public function setUnitTier(int $unitTier): self
    {
        $this->unitTier = $unitTier;

        return $this;
    }

    /**
     * Get the value of isExact
     *
     * @return bool
     */
    public function getIsExact(): bool
    {
        return $this->isExact;
    }

    /**
     * Set the value of isExact
     *
     * @param bool $isExact
     *
     * @return self
     */
    public function setIsExact(bool $isExact): self
    {
        $this->isExact = $isExact;

        return $this;
    }
}
