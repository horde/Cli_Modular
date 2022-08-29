<?php
/**
 * Copyright 2010-2022 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @author   Ralf Lang <ralf.lang@ralf-lang.de>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @package  Cli_Modular
 */
declare(strict_types=1);

namespace Horde\Cli\Modular;

/**
 * The interface for CLI Modular to handle argument and option parsing
 *
 * Abstracting this allows to plug alternatives.
 * All Parsers only handle input up to their specific level.
 * 
 * @author   Ralf Lang <ralf.lang@ralf-lang.de>
 * @category  Horde
 * @copyright 2010-2022 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @package   Cli_Modular
 */
interface ParserInterface
{

}
