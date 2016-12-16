<?php

/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */
class Family
{
    /** @var Human[] */
    protected $_parents = [];

    /**
     * Family constructor.
     * @param $parents
     */
    public function __construct($parents)
    {
        $this->_parents = $parents;
    }

    /**
     * @return array
     */
    public function getParents()
    {
        return $this->_parents;
    }

    /**
     * @param $human
     * @return mixed
     */
    public function addChild($human)
    {
        foreach ($this->_parents as $parent) {
            $parent->addChild($human);
        }

        return $human;
    }

    /**
     * @return mixed
     */
    public function getOlderChild()
    {
        $children = $this->getChildren();

        usort($children, function (Human $a, Human $b) {
            return $a->getId() > $b->getId();
        });

        return array_shift($children);
    }

    /**
     * @return Human|mixed
     */
    public function getChildren()
    {
        return array_reduce($this->_parents, function ($result, Human $parent) {
            return array_merge($result, $parent->getChildren());
        }, []);
    }
}