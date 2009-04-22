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
 * @version    $Id: Frontcontroller.php 14564 2009-03-31 16:39:50Z matthew $
 */

/**
 * @see Zend_Application_Resource_Base
 */
require_once 'Zend/Application/Resource/Base.php';

/**
 * Front Controller resource
 *
 * @category   Zend
 * @package    Zend_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Application_Resource_Frontcontroller extends Zend_Application_Resource_Base
{
    /**
     * @var Zend_Controller_Front
     */
    protected $_front;

    /**
     * Initialize Front Controller
     * 
     * @return void
     */
    public function init()
    {
        $front = $this->getFrontController();
        
        foreach ($this->getOptions() as $key => $value) {
            switch (strtolower($key)) {
                case 'controllerdirectory':
                    if (is_string($value)) {
                        $front->setControllerDirectory($value);
                    } elseif (is_array($value)) {
                        foreach ($value as $module => $directory) {
                            $front->setControllerDirectory($directory, $module);
                        }
                    }
                    break;
                    
                case 'modulecontrollerdirectoryname':
                    $front->setModuleControllerDirectoryName($value);
                    break;
                    
                case 'moduledirectory':
                    $front->addModuleDirectory($value);
                    break;
                    
                case 'defaultcontrollername':
                    $front->setDefaultControllerName($value);
                    break;
                    
                case 'defaultaction':
                    $front->setDefaultAction($value);
                    break;
                    
                case 'defaultmodule':
                    $front->setDefaultModule($value);
                    break;
                    
                case 'baseurl':
                    $front->setBaseUrl($value);
                    break;
                    
                case 'params':
                    $front->setParams($value);
                    break;
                    
                case 'plugins':
                    foreach ((array) $value as $pluginClass) {
                        $plugin = new $pluginClass();
                        $front->registerPlugin($plugin);
                    }
                    break;

                default:
                    $front->setParam($key, $value);
                    break;
            }
        }
        
        if (null !== ($bootstrap = $this->getBootstrap())) {
            $this->getBootstrap()->frontController = $front;
        }
    }

    /**
     * Retrieve front controller instance
     * 
     * @return Zend_Controller_Front
     */
    public function getFrontController()
    {
        if (null === $this->_front) {
            $this->_front = Zend_Controller_Front::getInstance();
        }
        return $this->_front;
    }
}
