<?php

/**
 * AppserverIo\Routlt\Description\ParamsInterceptor
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

use AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface;

/**
 * Interceptor that set's all request parameters to the action by using setter methods.
 *
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2015 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io/routlt
 * @link       http://www.appserver.io
 */
class ParamsInterceptor extends AbstractInterceptor
{

    /**
     * Iterates over all servlet request parameters and tries to find and
     * invoke a setter with the param that matches the setters name.
     *
     * @param \AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface $methodInvocation Initially invoked method
     *
     * @return string|null The action result
     */
    protected function execute(MethodInvocationInterface $methodInvocation)
    {

        // get the action, methods and servlet request
        $action = $this->getAction();
        $methods = $this->getActionMethods();
        $servletRequest = $this->getServletRequest();

        // try to inject the request parameters by using the class setters
        foreach ($servletRequest->getParameterMap() as $key => $value) {
            // prepare the setter method name
            $methodName = sprintf('set%s', ucfirst($key));

            // query whether the class has the setter implemented
            if (in_array($methodName, $methods) === false) {
                continue;
            }

            try {
                // set the value by using the setter
                $action->$methodName($value);

            } catch (\Exception $e) {
                $action->addFieldError($key, $e->getMessage());
            }
        }

        // proceed invocation chain
        return $methodInvocation->proceed();
    }
}
