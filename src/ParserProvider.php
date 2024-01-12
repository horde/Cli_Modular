<?php
namespace Horde\Cli\Modular;
use Horde\Argv\OptionGroup;
use Horde\Argv\Parser;
use Horde\Cli\Cli;

class ParserProvider
{
    public function __construct(private string $parserClass = Parser::class)
    {

    }
    /**
     * Return the class name for the parser that should be used.
     *
     * @return string The class name.
     */
    public function getParserClass(): string
    {
        return $this->parserClass;
    }


    public function createParser(Modules $modules, string $usage = ''): Parser
    {
        $parserClass = $this->getParserClass();
        $parser = new $parserClass(
            array(
                'usage' => '%prog ' . $usage
            )
        );
        foreach ($modules->listModules() as $module) {
            foreach ($module->getBaseOptions() as $option) {
                $parser->addOption($option);
            }
            if ($module->hasOptionGroup()) {
                $group = new OptionGroup(
                    $parser,
                    $module->getOptionGroupTitle(),
                    $module->getOptionGroupDescription()
                );
                foreach ($module->getOptionGroupOptions() as $option) {
                    $group->addOption($option);
                }
                $parser->addOptionGroup($group);
            }
        }
        return $parser;
    }

}