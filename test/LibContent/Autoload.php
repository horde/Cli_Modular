<?php
/**
 * Setup autoloading for the tests.
 *
 * PHP version 5
 *
 * Copyright 2009-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category   Horde
 * @package    Cli_Modular
 * @subpackage UnitTests
 * @author     Gunnar Wrobel <wrobel@pardus.de>
 * @license    http://www.horde.org/licenses/lgpl21 LGPL
 * @link       http://www.horde.org/components/Horde_Cli_Modular
 */

/** Load the basic test definition */
//require_once __DIR__ . '/TestCase.php';

/** Load stub classes */
require_once __DIR__ . '/Stub/Modules.php';
require_once __DIR__ . '/Stub/Provider.php';
require_once __DIR__ . '/Stub/Module/One.php';
