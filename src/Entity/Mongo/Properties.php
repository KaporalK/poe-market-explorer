<?php

namespace App\Entity\Mongo;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Properties
 * @package App\Entity\Mongo\Embedded
 * @MongoDB\Document
 */
class Properties
{

    /**
     * @MongoDB\Id(strategy="NONE", type="string")
     * @Groups({"item_get"})
     */
    private string $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private string $name;

    /**
     * @MongoDB\Field(type="int")
     */
    private int $displayMode;

    /**
     * @MongoDB\Field(type="int")
     */
    private ?int $type = null;

    /**
     * @MongoDB\Field(type="collection", nullable=true)
     */
    private array $values = [];


    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getDisplayMode(): int
    {
        return $this->displayMode;
    }

    /**
     * @param int $displayMode
     */
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

    /**
     * @return Items[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}