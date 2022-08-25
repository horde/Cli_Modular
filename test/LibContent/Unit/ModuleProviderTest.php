<?php
/**
 * Test the module provider.
 *
 * PHP version 5
 * Copyright 2010-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category   Kolab
 * @package    Cli_Modular
 * @subpackage UnitTests
 * @author     Gunnar Wrobel <wrobel@pardus.de>
 * @license    http://www.horde.org/licenses/lgpl21 LGPL
 * @link       http://www.horde.org/components/Horde_Cli_Modular
 */
namespace Horde\Cli\Modular\Test\LibContent\Unit;
use Horde\Cli\Modular\Test\LibContent\TestCase;
use \stdClass;
use \Horde_Cli_Modular_ModuleProvider;

/**
 * Test the module provider.
 */
class ModuleProviderTest extends TestCase
{

    public function testMissingPrefix()
    {
        $this->expectException('Horde_Cli_Modular_Exception');
        $provider = new Horde_Cli_Modular_ModuleProvider();
    }

    public function testInvalidModule()
    {
        $this->expectException('Horde_Cli_Modular_Exception');
        $provider = new Horde_Cli_Modular_ModuleProvider(
            array('prefix' => 'INVALID')
        );
        $provider->getModule('One')->getUsage('One');
    }

    public function testUsage()
    {
        $provider = new Horde_Cli_Modular_ModuleProvider(
            array(
                'prefix' => 'Horde\\Cli\\Modular\\Test\\LibContent\Stub\\Module\\',
                'dependencies' => new stdClass,
            )
        );
        $this->assertEquals(
            'Use One', $provider->getModule('One')->getUsage('One')
        );
    }

    public function testDependencies()
    {
        $dependencies = new stdClass;
        $provider = new Horde_Cli_Modular_ModuleProvider(
            array(
                'prefix' => 'Horde\\Cli\\Modular\\Test\\LibContent\\Stub\\Module\\',
                'dependencies' => $dependencies,
            )
        );
        $this->assertSame(
            $dependencies, $provider->getModule('One')->args[0]
        );
    }
}
