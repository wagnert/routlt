<?php

/**
 * AppserverIo\Routlt\Description\ResultDescriptor
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2015 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io/routlt
 * @link       http://www.appserver.io
 */

namespace AppserverIo\Routlt\Description;

use AppserverIo\Lang\Reflection\AnnotationInterface;
use AppserverIo\Configuration\Interfaces\NodeInterface;
use AppserverIo\Description\DescriptorReferencesTrait;
use AppserverIo\Description\AbstractNameAwareDescriptor;
use AppserverIo\Lang\Reflection\ClassInterface;
use AppserverIo\Routlt\Annotations\Result;

/**
 * Descriptor implementation for a action result.
 *
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2015 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io/routlt
 * @link       http://www.appserver.io
 */
class ResultDescriptor extends AbstractNameAwareDescriptor implements ResultDescriptorInterface
{

    /**
     * The trait with the references descriptors.
     *
     * @var AppserverIo\Description\DescriptorReferencesTrait
     */
    use DescriptorReferencesTrait;

    /**
     * The beans class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Sets the beans class name.
     *
     * @param string $className The beans class name
     *
     * @return void
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * Returns the beans class name.
     *
     * @return string The beans class name
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Returns a new descriptor instance.
     *
     * @return \AppserverIo\Routlt\Description\ResultDescriptorInterface The descriptor instance
     */
    public static function newDescriptorInstance()
    {
        return new ResultDescriptor();
    }

    /**
     * Returns a new annotation instance for the passed reflection class.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the bean configuration
     *
     * @return \AppserverIo\Lang\Reflection\AnnotationInterface The reflection annotation
     */
    protected function newAnnotationInstance(ClassInterface $reflectionClass)
    {
        return $reflectionClass->getAnnotation(Result::ANNOTATION);
    }

    /**
     * Initializes the bean configuration instance from the passed reflection class instance.
     *
     * @param \AppserverIo\Lang\Reflection\ClassInterface $reflectionClass The reflection class with the bean configuration
     *
     * @return \AppserverIo\Routlt\Description\PathDescriptorInterface The initialized descriptor
     */
    public function fromReflectionClass(ClassInterface $reflectionClass)
    {

        // query if we've an action
        if ($reflectionClass->implementsInterface('AppserverIo\Routlt\Results\ResultInterface') === false &&
            $reflectionClass->toPhpReflectionClass()->isAbstract() === false
        ) {
            // if not, do nothing
            return;
        }

        // create a new annotation instance
        $annotationInstance = $this->getClassAnnotation($reflectionClass, Result::class);

        // query if we've a servlet with a @Path annotation
        if ($annotationInstance === null) {
            // if not, do nothing
            return;
        }

        // load class name
        $this->setClassName($reflectionClass->getName());

        // load the default name to register in naming directory
        if ($nameAttribute = $annotationInstance->getName()) {
            $name = $nameAttribute;
        } else {
            // if @Annotation(name=****) is NOT set, we use the class name by default
            $name = $reflectionClass->getShortName();
        }

        // prepare and set the name
        $this->setName($name);

        // initialize the shared flag @Result(shared=true)
        $this->setShared($annotationInstance->getShared());

        // initialize references from the passed reflection class
        $this->referencesFromReflectionClass($reflectionClass);

        // return the instance
        return $this;
    }

    /**
     * Initializes the result configuration instance from the passed reflection annotation instance.
     *
     * @param \AppserverIo\Lang\Reflection\AnnotationInterface $reflectionAnnotation The reflection annotation with the result configuration
     *
     * @return \AppserverIo\Routlt\Description\ResultDescriptorInterface The initialized descriptor
     */
    public function fromReflectionAnnotation(AnnotationInterface $reflectionAnnotation)
    {
    }

    /**
     * Initializes a action configuration instance from the passed deployment descriptor node.
     *
     * @param \SimpleXmlElement $node The deployment node with the action configuration
     *
     * @return \AppserverIo\Routlt\Description\ActionDescriptorInterface The initialized descriptor
     */
    public function fromDeploymentDescriptor(\SimpleXmlElement $node)
    {
    }

    /**
     * Initializes a action configuration instance from the passed configuration node.
     *
     * @param \AppserverIo\Configuration\Interfaces\NodeInterface $node The configuration node with the action configuration
     *
     * @return \AppserverIo\Routlt\Description\ActionDescriptorInterface The initialized descriptor
     */
    public function fromConfiguration(NodeInterface $node)
    {
    }

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Routlt\Description\ResultDescriptorInterface $resultDescriptor The configuration to merge
     *
     * @return void
     * @throws \AppserverIo\Routlt\Description\DescriptorException Is thrown if the passed descriptor has a different method name
     */
    public function merge(ResultDescriptorInterface $resultDescriptor)
    {

        // check if the classes are equal
        if ($this->getName() !== $resultDescriptor->getName()) {
            throw new DescriptorException(
                sprintf('You try to merge a result configuration for % with %s', $resultDescriptor->getName(), $this->getName())
            );
        }

        // merge the class name
        if ($className = $resultDescriptor->getClassName()) {
            $this->setClassName($className);
        }

        // merge the shared flag
        $this->setShared($resultDescriptor->isShared());
    }
}
