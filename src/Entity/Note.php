<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\LessThanOrEqual(20)
     * @ORM\Column(type="float")
     */
    private $note;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="notes")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Discipline", inversedBy="notes")
     */
    private $discipline;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->discipline = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
        }

        return $this;
    }

    /**
     * @return Collection|Discipline[]
     */
    public function getDiscipline(): Collection
    {
        return $this->discipline;
    }

    public function addDiscipline(Discipline $discipline): self
    {
        if (!$this->discipline->contains($discipline)) {
            $this->discipline[] = $discipline;
        }

        return $this;
    }

    public function removeDiscipline(Discipline $discipline): self
    {
        if ($this->discipline->contains($discipline)) {
            $this->discipline->removeElement($discipline);
        }

        return $this;
    }
}
