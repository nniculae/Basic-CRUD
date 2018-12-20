<?php

namespace App\Entity;


use App\Exceptions\DinosaursAreRunningRampantException;
use App\Exceptions\NotABuffetException;
use App\Util\Dinosaur;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosure")
 */
class Enclosure
{

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"})
     * @var Collection
     */
    private $dinosaurs;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Security", mappedBy="enclosure")
     * @var Collection|Security[]
     */
    private $securities;

    /**
     * @return Collection
     */
    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    /**
     * Enclosure constructor.
     * @param $dinosaurs
     */
    public function __construct(bool $basicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if($basicSecurity){
            $this->addSecurity(new Security('Fence',true, $this));
        }
    }

    public function addDinosaur(Dinosaur $dinosaur): void
    {
        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotABuffetException();
        }
        if(!$this->isSecurityActive()){
            throw new DinosaursAreRunningRampantException('Are you mad?');
        }
        $this->dinosaurs[] = $dinosaur;

    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool
    {

        return count($this->dinosaurs) === 0
            || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security) {
            if ($security->getIsActive()) {
                return true;
            }
        }
        return false;
    }

    private function addSecurity(Security $security)
    {
        $this->securities[] = $security;
    }

}