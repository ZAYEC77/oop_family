<?php

/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */
class Human
{
    protected static $nextId = 0;

    public $name;

    protected $_id;

    /** @var Human[] */
    protected $_children = [];

    /**
     * Human constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->_id = ++self::$nextId;
    }

    /**
     * @param Human $human
     */
    public function addChild(Human $human)
    {
        $this->_children[$human->getId()] = $human;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return Human[]
     */
    public function getChildren()
    {
        return $this->_children;
    }
}