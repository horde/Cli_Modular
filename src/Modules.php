<?php
declare(strict_types=1);
namespace Horde\Cli\Modular;
use IteratorAggregate;
use Countable;
use Traversable;
use ArrayIterator;

class Modules
implements IteratorAggregate, Countable
{
    /**
     * The available modules.
     *
     * @var array
     */
    private $modules;

    /**
     * Constructor.
     *
     * BC Break: Modules only holds a list of readily constructed modules.
     * You need to create the module objects in a provider.
     */
    public function __construct(array $modules = [])
    {
        $this->modules = $modules;
    }

    /**
     * List the available modules.
     *
     * @return array The list of modules.
     */
    public function listModules()
    {
        return $this->modules;
    }

    /**
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->modules);
    }

    /**
     * Implementation of Countable count() method. Returns the number of modules.
     *
     * @return integer Number of modules.
     */
    public function count(): int
    {
        return count($this->modules);
    }
}