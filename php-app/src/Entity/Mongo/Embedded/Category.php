<?php

namespace App\Entity\Mongo\Embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class ExtendValue
 * @package App\Entity\Mongo\Embedded
 * @MongoDB\EmbeddedDocument
 */
class Category
{

    /**
     * @MongoDB\Field(type="string")
     * @Groups({"item_get"})
     */
    private string $category;
    /**
     * @MongoDB\Field(type="collection", nullable=true)
     * @Groups({"item_get"})
     */
    private array $subcategories = [];

    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private ?int $prefixes = null;

    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private ?int $suffixes = null;
  
    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubcategories(): array
    {
        return $this->subcategories;
    }

    public function setSubcategories(array $subcategories): self
    {
        $this->subcategories = $subcategories;

        return $this;
    }

    public function getPrefixes(): ?int
    {
        return $this->prefixes;
    }

    public function setPrefixes(?int $prefixes): self
    {
        $this->prefixes = $prefixes;

        return $this;
    }

    public function getSuffixes(): ?int
    {
        return $this->suffixes;
    }

    public function setSuffixes(?int $suffixes): self
    {
        $this->suffixes = $suffixes;

        return $this;
    }
}