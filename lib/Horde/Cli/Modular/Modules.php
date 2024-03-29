<?php
/**
 * Copyright 2010-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @package  Cli_Modular
 */

/**
 * The Horde_Cli_Modular_Modules:: class handles a set of CLI modules.
 *
 * @author    Gunnar Wrobel <wrobel@pardus.de>
 * @category  Horde
 * @copyright 2010-2017 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @package   Cli_Modular
 */
class Horde_Cli_Modular_Modules
implements IteratorAggregate, Countable
{
    /**
     * Parameters.
     *
     * @var array
     */
    private $_parameters;

    /**
     * The available modules.
     *
     * @var array
     */
    private $_modules;

    /**
     * Constructor.
     *
     * @param array $parameters Options for this instance.
     * <pre>
     *  - directory: (string) The path to the directory that holds the modules.
     *  - exclude:   (array) Exclude these modules from the list.
     * </pre>
     */
    public function __construct(array $parameters = null)
    {
        $this->_parameters = $parameters;
        $this->_initModules();
    }

    /**
     * Initialize the list of module class names.
     *
     * @return NULL
     *
     * @throws Horde_Cli_Modular_Exception In case the list of modules could not
     *                                     be established.
     */
    private function _initModules()
    {
        if (empty($this->_parameters['directory'])) {
            throw new Horde_Cli_Modular_Exception(
                'The "directory" parameter is missing!'
            );
        }
        if (!file_exists($this->_parameters['directory'])) {
            throw new Horde_Cli_Modular_Exception(
                sprintf(
                    'The indicated directory %s does not exist!',
                    $this->_parameters['directory']
                )
            );
        }
        if (!isset($this->_parameters['exclude'])) {
            $this->_parameters['exclude'] = array();
        } else if (!is_array($this->_parameters['exclude'])) {
            $this->_parameters['exclude'] = array($this->_parameters['exclude']);
        }
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->_parameters['directory'])) as $file) {
            if ($file->isFile() && preg_match('/.php$/', $file->getFilename())) {
                $class = preg_replace("/^(.*)\.php/", '\\1', $file->getFilename());
                if (!in_array($class, $this->_parameters['exclude'])) {
                    $this->_modules[] = $class;
                }
            }
        }
        sort($this->_modules);
    }

    /**
     * List the available modules.
     *
     * @return array The list of modules.
     */
    public function listModules()
    {
        return $this->_modules;
    }

    /**
     */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->_modules);
    }

    /**
     * Implementation of Countable count() method. Returns the number of modules.
     *
     * @return integer Number of modules.
     */
    public function count(): int
    {
        return count($this->_modules);
    }
}
