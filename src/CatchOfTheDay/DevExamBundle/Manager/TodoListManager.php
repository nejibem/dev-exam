<?php

namespace CatchOfTheDay\DevExamBundle\Manager;

use CatchOfTheDay\DevExamBundle\Model\TodoListItem;

class TodoListManager
{
    const DATA_FILE = '@CatchOfTheDayDevExamBundle/Resources/data/todo-list.json';

    /**
     * @var \Symfony\Component\Config\FileLocatorInterface
     */
    private $fileLocator;

    /**
     * @param \Symfony\Component\Config\FileLocatorInterface $fileLocator
     */
    public function __construct($fileLocator)
    {
        $this->fileLocator = $fileLocator;
    }

    /**
     * @return string
     */
    private function getDataFilePath()
    {
        return $this->fileLocator->locate(self::DATA_FILE);
    }

    /**
     * @return \CatchOfTheDay\DevExamBundle\Model\TodoListItem[]
     */
    public function read()
    {
        $jsonFile = $this->getDataFilePath();

        $todoData = json_decode(file_get_contents($jsonFile));
        $list = [];

        foreach($todoData as $todo)
        {
            $list[] = TodoListItem::fromAssocArray((array) $todo);
        }
        return $list;
    }

    /**
     * @param \CatchOfTheDay\DevExamBundle\Model\TodoListItem[] $items
     */
    public function write(array $items)
    {
        $jsonFile = $this->getDataFilePath();

        $list = [];
        foreach ($items as $item)
        {
            $list[] = $item->toAssocArray();
        }

        file_put_contents($jsonFile, json_encode($list));
    }
}