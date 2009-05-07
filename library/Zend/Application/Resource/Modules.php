<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Modules.php 14896 2009-04-14 21:09:43Z matthew $
 */

/**
 * Module bootstrapping resource
 *
 * @category   Zend
 * @package    Zend_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Application_Resource_Modules extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var ArrayObject
     */
    protected $_bootstraps;

    /**
     * Constructor
     * 
     * @param  mixed $options 
     * @return void
     */
    public function __construct($options = null)
    {
        $this->_bootstraps = new ArrayObject(array(), ArrayObject::ARRAY_AS_PROPS);
        parent::__construct($options);
    }

    /**
     * Initialize modules
     *
     * @return void
     * @throws Zend_Application_Resource_Exception When bootstrap class was not found
     */
    public function init()
    {
        $bootstrap = $this->getBootstrap();
        $bootstrap->bootstrap('frontcontroller');
        $front = $bootstrap->frontController;

        $modules = $front->getControllerDirectory();
        $default = $front->getDefaultModule();
        foreach (array_keys($modules) as $module) {
            if ($module === $default) {
                continue;
            }

            $bootstrapClass = ucfirst($module) . '_Bootstrap';
            if (!class_exists($bootstrapClass)) {
                $bootstrapPath  = $front->getModuleDirectory($module) . '/Bootstrap.php';
                if (file_exists($bootstrapPath)) {
                    include_once $bootstrapPath;
                    if (!class_exists($bootstrapClass, false)) {
                        throw new Zend_Application_Resource_Exception('Bootstrap file found for module "' . $module . '" but bootstrap class "' . $bootstrapClass . '" not found');
                    }
                } else {
                    continue;
                }
            }

            $moduleBootstrap = new $bootstrapClass($bootstrap);
            $moduleBootstrap->bootstrap();
            $this->_bootstraps[$module] = $moduleBootstrap;
        }

        return $this->_bootstraps;
    }

    /**
     * Get bootstraps that have been run
     * 
     * @return ArrayObject
     */
    public function getExecutedBootstraps()
    {
        return $this->_bootstraps;
    }
}
