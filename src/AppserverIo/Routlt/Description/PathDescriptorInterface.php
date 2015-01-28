<?php

/**
 * AppserverIo\Routlt\Description\PathDescriptorInterface
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

use AppserverIo\Appserver\DependencyInjectionContainer\Interfaces\DescriptorInterface;

/**
 * Descriptor for a action class implementation.
 *
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2015 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io/routlt
 * @link       http://www.appserver.io
 */
interface PathDescriptorInterface extends DescriptorInterface
{

    /**
     * Returns the action path.
     *
     * @return string The action path
     */
    public function getName();

    /**
     * Returns the action class name.
     *
     * @return string The action class name
     */
    public function getClassName();

    /**
     * The array with the action method descriptors.
     *
     * @return array The action method descriptors
     */
    public function getActions();

    /**
     * Merges the passed configuration into this one. Configuration values
     * of the passed configuration will overwrite the this one.
     *
     * @param \AppserverIo\Routlt\Description\PathDescriptorInterface $pathDescriptor The configuration to merge
     *
     * @return void
     */
    public function merge(PathDescriptorInterface $pathDescriptor);
}