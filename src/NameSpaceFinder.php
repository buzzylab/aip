<?php

namespace Buzzylab\Aip;

class NameSpaceFinder {

    /**
     * @var array
     */
    private $namespaceMap = [];

    /**
     * @var string
     */
    private $defaultNamespace = 'global';

    /**
     * NameSpaceFinder constructor.
     */
    public function __construct()
    {
        $this->traverseClasses();
    }

    /**
     * @param $class
     * @return string
     */
    private function getNameSpaceFromClass($class)
    {
        // Get the namespace of the given class via reflection.
        // The global namespace (for example PHP's predefined ones)
        // will be returned as a string defined as a property ($defaultNamespace)
        // own namespaces will be returned as the namespace itself

        $reflection = new \ReflectionClass($class);
        return $reflection->getNameSpaceName() === '' ? $this->defaultNamespace : $reflection->getNameSpaceName();
    }

    /**
     *
     */
    public function traverseClasses()
    {
        // Get all declared classes
        $classes = get_declared_classes();

        foreach($classes as $class)
        {
            // Store the namespace of each class in the namespace map
            $namespace = $this->getNameSpaceFromClass($class);
            $this->namespaceMap[$namespace][] = $class;
        }
    }

    /**
     * @return mixed
     */
    public function getNameSpaces()
    {
        return array_keys($this->namespaceMap);
    }

    /**
     * @param $namespace
     * @return mixed
     */
    public function getClassesOfNameSpace($namespace)
    {
        if(!isset($this->namespaceMap[$namespace]))
            throw new \InvalidArgumentException('The Namespace '. $namespace . ' does not exist');

        return $this->namespaceMap[$namespace];
    }

}