<?php

namespace App\Entity\Mongo;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\SearchFilter;
use App\Entity\Mongo\Embedded\Category;
use App\Entity\Mongo\Embedded\ItemsProperties;
use App\Entity\Mongo\Embedded\SocketsExt;
use App\Filter\ItemNameFilter;
use App\Filter\PropertiesFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Filter\ModsFilter;
use App\Filter\RarityFilter;

/**
 * Class Items
 * @package App\Entity\Mongo
 * @MongoDB\Document
 */
 #[ApiResource(
      attributes: ["normalization_context" => ["groups" => ["item_get"]]],
      itemOperations: [
           "get"
      ],
      collectionOperations: [
           "get"
      ]
)]
#[ApiFilter(
    SearchFilter::class, 
    properties: [
        'name' => 'partial',
        'baseType' => 'partial',
        'extended.category' => 'partial',
    ]
)]
#[ApiFilter(
    RangeFilter::class, 
    properties: [
        'socketsExt.G' , 
        'socketsExt.B' , 
        'socketsExt.R' , 
        'socketsExt.W' , 
        'socketsExt.socketCount' , 
        'socketsExt.link' , 
    ]
)]
#[ApiFilter(
    BooleanFilter::class, 
    properties: ['identified']
)]
#[ApiFilter(
    PropertiesFilter::class
)]
#[ApiFilter(
    ModsFilter::class
)]
#[ApiFilter(
    ItemNameFilter::class
)]
#[ApiFilter(
    RarityFilter::class
)]
class Items
{

    const RARITY_UNIQUE = 3;

    /**
     * @MongoDB\Id(strategy="NONE", type="string")
     */
    #[Groups(["item_get"])]
    private string $id;
    
    /**
     * @var bool $verified
     * @MongoDB\Field(type="bool")
     */
    #[Groups(["item_get"])]
    private bool $verified;
    
    /**
     * @var int $w
     * @MongoDB\Field(type="int")
     */
    #[Groups(["item_get"])]
    private int $w;
    
    /**
     * @var int $h
     * @MongoDB\Field(type="int")
     */
    #[Groups(["item_get"])]
    private int $h;
    
    /**
     * @var int $ilvl
     * @MongoDB\Field(type="int")
     */
    #[Groups(["item_get"])]
    private int $ilvl;
    
    /**
     * @var int $x
     * @MongoDB\Field(type="int")
     */
    #[Groups(["item_get"])]
    private int $x;
    
    /**
     * @var int $y
     * @MongoDB\Field(type="int")
     */
    #[Groups(["item_get"])]
    private int $y;
    
    /**
     * @var int $frameType
     * @MongoDB\Field(type="int")
     */
    #[Groups(["item_get"])]
    private int $frameType;
    
    /**
     * @var string $icon
     * @MongoDB\Field(type="string")
     */
    #[Groups(["item_get"])]
    private string $icon;
    
    /**
     * @var string $league
     * @MongoDB\Field(type="string")
     */
    #[Groups(["item_get"])]
    private string $league;
    
    /**
     * @var string $name
     * @MongoDB\Field(type="string")
     */
    #[Groups(["item_get"])]
    private string $name;
    
    /**
     * @MongoDB\Field(type="string")
     */
    #[Groups(["item_get"])]
    private string $typeLine;
    
    /**
     * @MongoDB\Field(type="string")
     */
    #[Groups(["item_get"])]
    private string $baseType;
    
    /**
     * @MongoDB\Field(type="string", nullable=true)
     */
    #[Groups(["item_get"])]
    private ?string $note = null;
    
    /**
     * @MongoDB\Field(type="string")
     */
    #[Groups(["item_get"])]
    private string $inventoryId;
    
    /**
     * @MongoDB\Field(type="string", nullable=true)
     */
    #[Groups(["item_get"])]
    private ?string $descrText = null;
    
    /**
     * @MongoDB\Field(type="string", nullable=true)
     */
    #[Groups(["item_get"])]
    private ?string $secDescrText= null;
    
    /**
     * @MongoDB\Field(type="bool")
     */
    #[Groups(["item_get"])]
    private bool $identified;
    
    /**
     * @MongoDB\Field(type="bool", nullable=true)
     */
    #[Groups(["item_get"])]
    private ?bool $corrupted = null;
    
    /**
     * TODO rework ?
     * @var string[] $explicitMods
     * @MongoDB\Field(type="collection", nullable=true)
     */
    #[Groups(["item_get"])]
    private array $explicitMods = [];
    
    /**
     * TODO rework ?
     * @var string[] $implicitMods
     * @MongoDB\Field(type="collection", nullable=true)
     */
    #[Groups(["item_get"])]
    private array $implicitMods = [];
    
    /**
     * TODO rework ?
     * @var string[] $craftedMods
     * @MongoDB\Field(type="collection", nullable=true)
     */
    #[Groups(["item_get"])]
    private array $craftedMods = [];
    
    /**
     * TODO rework ?
     * @var array $utilityMods
     * @MongoDB\Field(type="collection", nullable=true)
     */
    #[Groups(["item_get"])]
    private array $utilityMods = [];
    
    /**
     * TODO rework ?
     * @var string[] $flavourText
     * @MongoDB\Field(type="collection", nullable=true)
     */
    #[Groups(["item_get"])]
    private array $flavourText = [];
    
    /**
     * @var ItemsProperties[]&ArrayCollection $properties     
     * @MongoDB\EmbedMany(targetDocument=ItemsProperties::class)
     */
    #[Groups(["item_get"])]
    private iterable $properties;
    
    /**
     * @var Category $extended     
     * @MongoDB\EmbedOne(targetDocument=Category::class)
     */
    #[Groups(["item_get"])]
    private ?Category $extended = null;
    
    /**
     * @var Socket[] $sockets     
     * @MongoDB\Field(type="collection", nullable=true)
     */
    #[Groups(["item_get"])]
    private array $sockets = [];
    
    /**
     * @var SocketsExt $socketsExt     
     * @MongoDB\EmbedOne(targetDocument=SocketsExt::class)
     */
    #[Groups(["item_get"])]
    private ?SocketsExt $socketsExt = null;
    
    /**
     * @var array $requirements     
     * @MongoDB\Field(type="collection", nullable=true)
     */
    #[Groups(["item_get"])]
    private array $requirements = [];
    
    /**
     * @var array $nextLevelRequirements     
     * @MongoDB\Field(type="collection", nullable=true)
     */
    #[Groups(["item_get"])]
    private array $nextLevelRequirements = [];
    
    /**
     * //todo pour les gems
     * @var array $socketedItems     
     * @MongoDB\Field(type="collection", nullable=true)
     */
    #[Groups(["item_get"])]
    private array $socketedItems = [];
    
    /**
     * @var null|bool $support     
     * @MongoDB\Field(type="bool", nullable=true)
     */
    #[Groups(["item_get"])]
    private ?bool $support = null;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument=Stashes::class, inversedBy="items", storeAs="id")
     */
    #[Groups(["item_get"])]
    private Stashes $stashe;
    
    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->verified;
    }

    /**
     * @param bool $verified
     */
    public function setVerified(bool $verified): void
    {
        $this->verified = $verified;
    }

    /**
     * @return int
     */
    public function getW(): int
    {
        return $this->w;
    }

    /**
     * @param int $w
     */
    public function setW(int $w): void
    {
        $this->w = $w;
    }

    /**
     * @return int
     */
    public function getH(): int
    {
        return $this->h;
    }

    /**
     * @param int $h
     */
    public function setH(int $h): void
    {
        $this->h = $h;
    }

    /**
     * @return int
     */
    public function getIlvl(): int
    {
        return $this->ilvl;
    }

    /**
     * @param int $ilvl
     */
    public function setIlvl(int $ilvl): void
    {
        $this->ilvl = $ilvl;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getFrameType(): int
    {
        return $this->frameType;
    }

    /**
     * @param int $frameType
     */
    public function setFrameType(int $frameType): void
    {
        $this->frameType = $frameType;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getLeague(): string
    {
        return $this->league;
    }

    /**
     * @param string $league
     */
    public function setLeague(string $league): void
    {
        $this->league = $league;
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
     * @return string
     */
    public function getTypeLine()
    {
        return $this->typeLine;
    }

    /**
     * @param string $typeLine
     */
    public function setTypeLine(string $typeLine): void
    {
        $this->typeLine = $typeLine;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getInventoryId(): string
    {
        return $this->inventoryId;
    }

    /**
     * @param string $inventoryId
     */
    public function setInventoryId(string $inventoryId): void
    {
        $this->inventoryId = $inventoryId;
    }

    /**
     * @return bool
     */
    public function isIdentified(): bool
    {
        return $this->identified;
    }

    /**
     * @param bool $identified
     */
    public function setIdentified(bool $identified): void
    {
        $this->identified = $identified;
    }

    /**
     * @return string[]
     */
    public function getExplicitMods()
    {
        return $this->explicitMods;
    }

    /**
     * @param string[] $explicitMods
     */
    public function setExplicitMods(array $explicitMods): void
    {
        $this->explicitMods = $explicitMods;
    }

    /**
     * @return string[]
     */
    public function getFlavourText()
    {
        return $this->flavourText;
    }

    /**
     * @param string[] $flavourText
     */
    public function setFlavourText(array $flavourText): void
    {
        $this->flavourText = $flavourText;
    }

    /**
     * @return ?string
     */
    public function getSecDescrText(): ?string
    {
        return $this->secDescrText;
    }

    /**
     * @param string $secDescrText
     */
    public function setSecDescrText($secDescrText): void
    {
        $this->secDescrText = $secDescrText;
    }

    /**
     * @return ?string
     */
    public function getDescrText(): ?string
    {
        return $this->descrText;
    }

    /**
     * @param string $descrText
     */
    public function setDescrText($descrText): void
    {
        $this->descrText = $descrText;
    }

    public function getSockets(): array
    {
        return $this->sockets;
    }

    public function setSockets(array $sockets)
    {
        $this->sockets = $sockets;
    }

    public function getRequirements(): array
    {
        return $this->requirements;
    }

    public function setRequirements(array $requirements)
    {
        $this->requirements = $requirements;
    }

    public function getStashe(): Stashes
    {
        return $this->stashe;
    }

    public function setStashe(Stashes $stashe)
    {
        $this->stashe = $stashe;
    }

    public function getBaseType(): string
    {
        return $this->baseType;
    }

    public function setBaseType(string $baseType)
    {
        $this->baseType = $baseType;
    }

    public function getProperties(): array
    {
        return $this->properties->getValues();
    }

    public function setProperties(array $properties)
    {
        $this->properties = $properties;
    }

    public function getSocketedItems(): array
    {
        return $this->socketedItems;
    }

    public function setSocketedItems(array $socketedItems)
    {
        $this->socketedItems = $socketedItems;
    }

    public function getSupport(): ?bool
    {
        return $this->support;
    }

    public function setSupport(?bool $support)
    {
        $this->support = $support;
    }

    public function getNextLevelRequirements(): array
    {
        return $this->nextLevelRequirements;
    }

    public function setNextLevelRequirements(array $nextLevelRequirements)
    {
        $this->nextLevelRequirements = $nextLevelRequirements;
    }

    public function getImplicitMods(): array
    {
        return $this->implicitMods;
    }

    public function setImplicitMods(array $implicitMods)
    {
        $this->implicitMods = $implicitMods;
    }

    public function getCraftedMods(): array
    {
        return $this->craftedMods;
    }

    public function setCraftedMods(array $craftedMods)
    {
        $this->craftedMods = $craftedMods;
    }

    public function getUtilityMods(): array
    {
        return $this->utilityMods;
    }

    public function setUtilityMods(array $utilityMods)
    {
        $this->utilityMods = $utilityMods;
    }

    public function getExtended(): Category
    {
        return $this->extended;
    }

    public function setExtended(Category $extended)
    {
        $this->extended = $extended;
    }

    public function getSocketsExt(): ?SocketsExt
    {
        return $this->socketsExt;
    }

    public function setSocketsExt(SocketsExt $socketsExt): self
    {
        $this->socketsExt = $socketsExt;

        return $this;
    }

    public function getCorrupted(): ?bool
    {
        return $this->corrupted;
    }

    public function setCorrupted(bool $corrupted): self
    {
        $this->corrupted = $corrupted;

        return $this;
    }
}
