<?php
/**
 * Created by PhpStorm.
 * User: KaporalK
 * Date: 01/06/2019
 * Time: 20:48
 */

namespace App\Entity\Mongo;


use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use App\Entity\Mongo\Items;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * Class Object
 *
 * @MongoDB\Document
 * @ApiResource(
 *     itemOperations={
 *          "get"
 *     },
 *     collectionOperations={
 *          "get"
 *     }
 * )
 */
class Stashes
{


    /**
     * @MongoDB\Id(strategy="NONE", type="string")
     */
    public string $id;

    /**
     * @MongoDB\Field(type="bool", nullable=true, name="public")
     */
    public ?bool $isPublic;

    /**
     * @MongoDB\Field(type="string", nullable=true)
     */
    public ?string $accountName;

    /**
     * @MongoDB\Field(type="string", nullable=true)
     */
    public ?string $lastCharacterName;

    /**
     * @MongoDB\Field(type="string", nullable=true)
     */
    public ?string $stash;

    /**
     * @MongoDB\Field(type="string", nullable=true)
     */
    public ?string $stashType;

    /**
     * @MongoDB\Field(type="string", nullable=true)
     */
    public ?string $league;

    /**
     * @var array&ArrayCollection $items
     * @MongoDB\ReferenceMany(targetDocument=Items::class, mappedBy="stashe", cascade={"persist"}, storeAs="id")
     * @ApiSubresource(resourceClass=Items::class)
     */
    public iterable $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Stashes
     */
    public function setId(string $id): Stashes
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ?bool
     */
    public function isPublic(): ?bool
    {
        return $this->isPublic;
    }

    /**
     * @param bool $isPublic
     * @return Stashes
     */
    public function setIsPublic(?bool $isPublic): Stashes
    {
        $this->isPublic = $isPublic;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * @param mixed $accountName
     * @return Stashes
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastCharacterName()
    {
        return $this->lastCharacterName;
    }

    /**
     * @param mixed $lastCharacterName
     * @return Stashes
     */
    public function setLastCharacterName($lastCharacterName)
    {
        $this->lastCharacterName = $lastCharacterName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStash()
    {
        return $this->stash;
    }

    /**
     * @param mixed $stash
     * @return Stashes
     */
    public function setStash($stash)
    {
        $this->stash = $stash;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStashType()
    {
        return $this->stashType;
    }

    /**
     * @param mixed $stashType
     * @return Stashes
     */
    public function setStashType($stashType)
    {
        $this->stashType = $stashType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * @param mixed $league
     * @return Stashes
     */
    public function setLeague($league)
    {
        $this->league = $league;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return Stashes
     */
    public function setItems(array $items): Stashes
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param Items $itempoe
     */
    public function addItem(Items $itempoe)
    {
        if(!$this->items->contains($itempoe)){
            $this->items[] = $itempoe;
        }
    }

    /**
     * @param Items $items
     */
    public function removeItem(Items $items)
    {
        $this->items->removeElement($items);
    }


}