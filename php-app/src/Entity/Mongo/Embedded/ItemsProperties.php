<?php

namespace App\Entity\Mongo\Embedded;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class ItemProperties
 * @package App\Entity\Mongo\Embedded
 * @MongoDB\EmbeddedDocument
 */
class ItemsProperties
{

    /**
     * @MongoDB\Field(type="string")
     * @Groups({"item_get"})
     */
    private string $name;

    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private int $displayMode;

    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private ?int $type = null;

    /**
     * @MongoDB\Field(type="collection", nullable=true)
     * @Groups({"item_get"})
     */
    private array $values = [];

    /**
     * @MongoDB\EmbedOne(targetDocument=ExtendValue::class)
     * @Groups({"item_get"})
     */
    private ?ExtendValue $extendValues = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDisplayMode(): int
    {
        return $this->displayMode;
    }

    public function setDisplayMode(int $displayMode): void
    {
        $this->displayMode = $displayMode;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): void
    {
        $this->type = $type;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function setValues(array $values): void
    {
        $this->values = $values;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getExtendValues(): ?ExtendValue
    {
        return $this->extendValues;
    }

    public function setExtendValues(?ExtendValue $extendValues)
    {
        $this->extendValues = $extendValues;
    }
}