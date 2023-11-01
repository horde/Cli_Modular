<?php
declare(strict_types=1);
namespace Horde\Cli\Modular;
use Horde\Cli\Cli;

class ModularCli
{
    public function __construct(protected Cli $cli, protected Modules $modules, protected ParserProvider $parserProvider, protected string $globalUsage = '')
    {

    }

    public function getModules(): Modules
    {
        return $this->modules;
    }

    public function getParser()
    {
        return $this->parserProvider->createParser($this->modules, $this->getModuleUsage($this->modules, $this->globalUsage));
    }
    /**
     * Return the usage description for the help output of the parser.
     *
     * @return string The usage description.
     */
    public function getModuleUsage(Modules $modules, string $globalUsage)
    {
        if (empty($globalUsage)) {
            $usage = '[options]';
        } else {
            $usage = $globalUsage;
        }

        $usageInterface = true;
        $length = 0;
        foreach ($modules as $module) {
            if ($module instanceof ModuleUsage) {
                $length = max($length, strlen($module->getTitle()));
            } else {
                $usageInterface = false;
                break;
            }
        }

        if (!$usageInterface) {
            foreach ($modules as $module) {
                $usage .= $module->getUsage();
            }
            return $usage;
        }

        $indent = str_repeat(' ', $length + 5);
        $width = $this->cli->getWidth();
        foreach ($modules as $module) {
            if (!strlen($module->getTitle())) {
                continue;
            }
            $moduleUsage = $module->getUsage();
            if ($width) {
                $moduleUsage = wordwrap(
                    $moduleUsage,
                    $width - $length - 5,
                    "\n" . $indent,
                    true
                );
            }
            $usage .= sprintf(
                "%s - %s\n",
                $this->cli->color(
                    'green',
                    sprintf('  %-' . $length . 's', $module->getTitle())
                ),
                $moduleUsage
            );
        }

        return $usage;
    }

    /**
     * Constructor.
     *
     * @param array $parameters Options for this instance.
     *  - parser
     *    - class:   Class name of the parser that should be used to parse
     *               command line arguments. Defaults to 'Horde_Argv_Parser'.
     *    - usage:   The usage decription shown in the help output of the CLI
     *  - modules:   Determines the handler for modules. Can be one of:
     *               (array)  A parameter array.
     *                        See Horde_Cli_Modular_Modules::__construct()
     *               (string) A class name.
     *               (object) An instance of Horde_Cli_Modular_Modules
     *  - provider:  Determines the module provider. Can be one of:
     *               (array)  A parameter array.
     *                        See
     *                        Horde_Cli_Modular_ModuleProvider::__construct()
     *               (string) A class name.
     *               (object) An instance of Horde_Cli_Modular_ModuleProvider
     *  - cli:       (Horde_Cli) A Horde_Cli object for usage formatting.
     */
    public static function fromLegacyArray(array $parameters)
    {
        // TODO: Upgrade aid
    }
}