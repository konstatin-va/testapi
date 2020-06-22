<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\ProductRepository")
 * @ORM\Table(name="ta_product")
 */
class Product
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
    private $name;

    /** 
     * @ORM\Column(type="float") 
     */
    private $cost;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param float $cost
     */
    public function setCost(float $cost): self
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost;
    }
}
