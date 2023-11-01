<?php
namespace Horde\Cli\Modular;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
/**
 * Scans a directory for modules with predictable classnames
 *
 */
class FilesystemModuleFinder
{
    public function __construct(private string $directory, private array $excludedClassNames = [])
    {

    }

    /**
     * Initialize the list of module class names.
     *
     *
     * @throws ModularCliException In case the list of modules could not
     *                                     be established.
     */
    public function scanModules(): array
    {
        $foundModules = [];
        // Should only apply to empty string
        if (empty($this->directory)) {
            throw new ModularCliException(
                'The "directory" parameter is missing!'
            );
        }
        if (!file_exists($this->directory)) {
            throw new ModularCliException(
                sprintf(
                    'The indicated directory %s does not exist!',
                    $this->directory
                )
            );
        }
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->directory)) as $file) {
            if ($file->isFile() && preg_match('/.php$/', $file->getFilename())) {
                $class = preg_replace("/^(.*)\.php/", '\\1', $file->getFilename());
                if (!in_array($class, $this->excludedClassNames)) {
                    $foundModules[] = $class;
                }
            }
        }
        sort($foundModules);
        return $foundModules;
    }
}