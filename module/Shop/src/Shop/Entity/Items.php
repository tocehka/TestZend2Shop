<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Items
 *
 * @ORM\Table(name="items", uniqueConstraints={@ORM\UniqueConstraint(name="Articul", columns={"Articul"})})
 * @ORM\Entity
 */
class Items
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Articul", type="string", length=6, nullable=true)
     */
    private $articul;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Item", type="string", length=255, nullable=true)
     */
    private $item;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Prod", type="string", length=255, nullable=true)
     */
    private $prod;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Color", type="string", length=50, nullable=true)
     */
    private $color;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Sale", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $sale;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date", type="date", nullable=true)
     */
    private $date;



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set articul.
     *
     * @param string|null $articul
     *
     * @return Items
     */
    public function setArticul($articul = null)
    {
        $this->articul = $articul;

        return $this;
    }

    /**
     * Get articul.
     *
     * @return string|null
     */
    public function getArticul()
    {
        return $this->articul;
    }

    /**
     * Set item.
     *
     * @param string|null $item
     *
     * @return Items
     */
    public function setItem($item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item.
     *
     * @return string|null
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set prod.
     *
     * @param string|null $prod
     *
     * @return Items
     */
    public function setProd($prod = null)
    {
        $this->prod = $prod;

        return $this;
    }

    /**
     * Get prod.
     *
     * @return string|null
     */
    public function getProd()
    {
        return $this->prod;
    }

    /**
     * Set type.
     *
     * @param string|null $type
     *
     * @return Items
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set color.
     *
     * @param string|null $color
     *
     * @return Items
     */
    public function setColor($color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color.
     *
     * @return string|null
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set price.
     *
     * @param string|null $price
     *
     * @return Items
     */
    public function setPrice($price = null)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set sale.
     *
     * @param string|null $sale
     *
     * @return Items
     */
    public function setSale($sale = null)
    {
        $this->sale = $sale;

        return $this;
    }

    /**
     * Get sale.
     *
     * @return string|null
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * Set date.
     *
     * @param \DateTime|null $date
     *
     * @return Items
     */
    public function setDate($date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }

    public function exchangeArray($data){
        foreach($data as $key => $value){
            if(property_exists($this,$key)){
                $this->$key = ($value !== null) ? $value : null;
            }
        }
        date_default_timezone_set('Europe/Moscow');
        $this->date = new \DateTime(date('Y-m-d'));
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
