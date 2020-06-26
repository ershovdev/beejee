<?php

namespace App\Db;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\TaskRepository")
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $status;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    protected $edited;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     */
    protected $user;

    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function isEdited()
    {
        return $this->edited;
    }

    public function setUser(User $user)
    {
        $user->assignedToTask($this);
        $this->user = $user;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setEdited($edited)
    {
        $this->edited = $edited;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
}