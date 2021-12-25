<?php

namespace App\Entity\Mongo\Embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class SocketsExt
 * @package App\Entity\Mongo\Embedded
 * @MongoDB\EmbeddedDocument
 */
class SocketsExt
{

    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private int $socketCount;
    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private int $G;
    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private int $B;
    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private int $R;
    /**
     * @MongoDB\Field(type="int")
     * @Groups({"item_get"})
     */
    private int $W;
    /**
     * @MongoDB\Field(type="collection", nullable=true)
     * @Groups({"item_get"})
     */
    private array $link;
    /**
     * @MongoDB\Field(type="string")
     * @Groups({"item_get"})
     */
    private string $linkStr;
  

    public function getSocketCount(): int
    {
        return $this->socketCount;
    }

    public function setSocketCount(int $socketCount)
    {
        $this->socketCount = $socketCount;

    }

    public function getG(): int
    {
        return $this->G;
    }

    public function setG(int $G)
    {
        $this->G = $G;
    }

    public function getB(): int
    {
        return $this->B;
    }

    public function setB(int $B): self
    {
        $this->B = $B;

        return $this;
    }

    public function getR(): int
    {
        return $this->R;
    }

    public function setR(int $R): self
    {
        $this->R = $R;

        return $this;
    }

    public function getW(): int
    {
        return $this->W;
    }

    public function setW(int $W): self
    {
        $this->W = $W;

        return $this;
    }

    public function getLink(): array
    {
        return $this->link;
    }

    public function setLink(array $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getLinkStr(): string
    {
        return $this->linkStr;
    }


    public function setLinkStr(string $linkStr): self
    {
        $this->linkStr = $linkStr;

        return $this;
    }
}