<?php
    class node 
    {
        private $value;

        private $parent;

        private $children = [];

        public function setValue($value)
        {
            $this->value = $value;
            return $this;
        }

        public function getValue()
        {
            return $this->value;
        }

        public function addChild($child)
        {
            $child->setParent($this);
            $this->children[] = $child;

            return $this;
        }

        public function getChildren()
        {
            return $this->children;
        }

        public function setChildren(array $children)
        {
            $this->removeParentFromChildren();
            $this->children = [];

            foreach ($children as $child) {
                $this->addChild($child);
            }

            return $this;
        }

        public function getParent()
        {
            return $this->parent;
        }

        public function setParent($parent = null)
        {
            $this->parent = $parent;
        }

        private function removeParentFromChildren()
        {
            foreach ($this->getChildren() as $child) {
                $child->setParent(null);
            }
        }

        public function __construct($value = null, array $children = [])
        {
            $this->setValue($value);

            if (!empty($children)) {
                $this->setChildren($children);
            }
        }
    }
?>