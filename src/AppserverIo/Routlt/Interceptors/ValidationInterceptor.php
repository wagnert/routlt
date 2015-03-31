<?php

/**
 * AppserverIo\Routlt\Description\ValidationInterceptor
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

namespace AppserverIo\Routlt\Interceptors;

use AppserverIo\Routlt\Util\ValidationAware;
use AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface;

/**
 * Interceptor that invokes the validate() method of an action if it
 * implements the ValidationAware interface.
 *
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2015 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io/routlt
 * @link       http://www.appserver.io
 */
class ValidationInterceptor implements InterceptorInterface
{

    /**
     * Method that implements the interceptors functionality.
     *
     * @param AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface $methodInvocation Initially invoked method
     *
     * @return string|null The action result
     */
    public function intercept(MethodInvocationInterface $methodInvocation)
    {

        try {

            error_log(__METHOD__ . '::' . __LINE__);

            // get the servlet response
            $parameters = $methodInvocation->getParameters();
            $servletResponse = $parameters['servletResponse'];

            // load the action instance
            $action = $methodInvocation->getContext();

            // validate getter/setter or properties here

            // proceed invocation chain
            return $methodInvocation->proceed();

        } catch (\Exception $e) {
            error_log($e);
        }
    }
}
