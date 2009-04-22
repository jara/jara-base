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
 * @version    $Id: Base.php 14315 2009-03-13 19:26:18Z matthew $
 */

/**
 * @see Zend_Application_Resource_IResource
 */
require_once 'Zend/Application/Resource/IResource.php';

/**
 * Abstract class for bootstrap resources
 *
 * @uses       Zend_Application_Resource_IResource
 * @category   Zend
 * @package    Zend_Application
 * @subpackage Resource
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Application_Resource_Base implements Zend_Application_Resource_IResource
{
    /**
     * Parent bootstrap
     * 
     * @var Zend_Application_Bootstrap_IBootstrap
     */
    protected $_bootstrap;

    /**
     * Options for the resource
     * 
     * @var array
     */
    protected $_options = array();

    /**
     * Option keys to skip when calling setOptions()
     *
     * @var array
     */
    protected $_skipOptions = array(
        'options',
        'config',
    );

    /**
     * Create a instance with options
     *
     * @param mixed $options
     */
    public function __construct($options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        } else if ($options instanceof Zend_Config) {
            $this->setOptions($options->toArray());
        }
    }

    /**
     * Set options from array
     *
     * @param  array $options Configuration for resource
     * @return Zend_Application_Resource_Base
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            if (in_array(strtolower($key), $this->_skipOptions)) {
                continue;
            }

            $method = 'set' . strtolower($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        
        $this->_options += $options;

        return $this;
    }

    /**
     * Retrieve resource options
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Set the bootstrap to which the resource is attached
     * 
     * @param  Zend_Application_Bootstrap_IBootstrap $bootstrap 
     * @return Zend_Application_Resource_IResource
     */
    public function setBootstrap(Zend_Application_Bootstrap_IBootstrap $bootstrap)
    {
        $this->_bootstrap = $bootstrap;
        return $this;
    }

    /**
     * Retrieve the bootstrap to which the resource is attached
     * 
     * @return null|Zend_Application_Bootstrap_IBootstrap
     */
    public function getBootstrap()
    {
        return $this->_bootstrap;
    }
}
