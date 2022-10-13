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
     * @MongoDB\Field(type="string")
     * @Groups({"item_get"})
     */
    private string $slug;
    
    /**
     * @MongoDB\Field(type="string")
     * @Groups({"item_get"})
     */
    private string $search;

    /**
     * @MongoDB\Field(type="collection", nullable=true)
     * @Groups({"item_get"})
     */
    private ?array $numValue = null;

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

    public function getNumValue(): ?array
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

    /**
     * Get the value of slug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @param string $slug
     *
     * @return self
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of search
     *
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    /**
     * Set the value of search
     *
     * @param string $search
     *
     * @return self
     */
    public function setSearch(string $search): self
    {
        $this->search = $search;

        return $this;
    }
}
