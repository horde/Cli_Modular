<?php
declare(strict_types=1);
namespace Horde\Cli\Modular;

interface ModuleProvider
{
    /**
     * Return the specified module.
     *
     * @param string $module The desired module.
     *
     * @return Module The module instance.
     *
     * @throws ModularCliException In case the specified module does not
     * exist.
     */
    public function getModule(string $module): Module;
}