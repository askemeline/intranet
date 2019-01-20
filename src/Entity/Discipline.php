<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 *  @UniqueEntity("discipline")
 * @ORM\Entity(repositoryClass="App\Repository\DisciplineRepository")
 */
class Discipline
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $discipline;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="disciplines")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Note", mappedBy="discipline")
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="discipline")
     */
    private $users;



    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscipline()
    {
        return $this->discipline;
    }

    public function setDiscipline($discipline): self
    {
        $this->discipline = $discipline;

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
    /*    public function __toString()
        {
            $output = '';
            foreach($this->discipline as $script){
                $output .= ' '.$script;
            }
            return $output;

        }*/
    /*dump($output);die;*/
    public function __toString() {
        return (string) $this->discipline;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->addDiscipline($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            $note->removeDiscipline($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }
}
