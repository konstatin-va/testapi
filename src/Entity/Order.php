<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\OrderRepository")
 * @ORM\Table(name="ta_order")
 */
class Order
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /** 
     * @ORM\Column(type="string") 
     */
    private $products;

    /** 
     * @ORM\Column(type="float") 
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $status = 0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $products
     */
    public function setProducts(string $products): self
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return string
     */
    public function getProducts(): string
    {
        return $this->products;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
