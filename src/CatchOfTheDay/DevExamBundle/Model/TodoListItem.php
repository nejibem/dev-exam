<?php

namespace CatchOfTheDay\DevExamBundle\Model;

class TodoListItem
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var string
     */
    private $text;

    /**
     * @var bool
     */
    private $complete;

    public function __construct()
    {
        $this->id = bin2hex(random_bytes(10));

        $this->created = new \DateTime();
        $this->complete = false;
    }

    /**
     * @return mixed
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $complete
     * @return TodoListItem
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;

        return $this;
    }

    /**
     * @param \DateTime $created
     * @return TodoListItem
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param string $id
     * @return TodoListItem
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $text
     * @return TodoListItem
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param array $data
     * @return TodoListItem
     */
    public static function fromAssocArray(array $data)
    {
        $item = new TodoListItem();

        $item->setId($data['id'])
             ->setText($data['text'])
             ->setComplete($data['complete'])
             ->setCreated( \DateTime::createFromFormat('Y-m-d H:i:s', $data['created']));

        return $item;
    }

    /**
     * @return array
     */
    public function toAssocArray()
    {
        $data = [
            'id'       => $this->getId(),
            'text'     => $this->getText(),
            'complete' => $this->getComplete(),
            'created'  => $this->getCreated()->format('Y-m-d H:i:s'),
        ];

        return $data;
    }
}