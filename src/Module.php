<?php
declare(strict_types=1);
namespace Horde\Cli\Modular;

interface Module
{
    /**
     * Returns additional usage description for this module.
     *
     * This description will be added after the automatically generated usage
     * line, so make sure to add any necessary line breaks or other separators.
     *
     * @todo This should be split up in title and usage, so that (action)
     *       titles can be colorized and descriptions can be lined up
     *       automatically.
     *
     * @return string  The description.
     */
    public function getUsage(): string;

    /**
     * Returns a set of base options that this module adds to the CLI argument
     * parser.
     *
     * @return iterable  Global options. A list of Horde_Argv_Option objects.
     */
    public function getBaseOptions(): iterable;

    /**
     * Returns whether the module provides an option group.
     *
     * @return bool  True if an option group should be added.
     */
    public function hasOptionGroup(): bool;

    /**
     * Returns the title for the option group representing this module.
     *
     * @return string  The group title.
     */
    public function getOptionGroupTitle(): string;

    /**
     * Returns the description for the option group representing this module.
     *
     * @return string  The group description.
     */
    public function getOptionGroupDescription(): string;

    /**
     * Returns the options for this module.
     *
     * @return iterable  The group options. A list of Horde_Argv_Option objects.
     */
    public function getOptionGroupOptions(): iterable;
}