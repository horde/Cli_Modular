<?php
/**
 * Test the module wrapper.
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

use Horde\Cli\Modular\Test\LibContent\Stub\Modules;
use Horde\Cli\Modular\Test\LibContent\TestCase;
use \Horde_Cli_Modular;
use \Horde_Cli_Modular_Modules;
use \Horde_Cli_Modular_ModuleProvider;
use Horde_Argv_Parser;

/**
 * Test the module wrapper.
 */
class ModularTest extends TestCase
{
    public function setUp(): void
    {
        $_SERVER['argv'] = array('test');
    }

    public function tearDown(): void
    {
        unset($_SERVER['argv']);
    }

    public function testParser()
    {
        $modular = new Horde_Cli_Modular(
            array(
                'modules' => array(
                    'directory' => __DIR__ . '/../Stub/Module'
                ),
                'provider' => array(
                    'prefix' => 'Horde\\Cli\\Modular\\Test\\LibContent\\Stub\\Module\\'
                ),
            )
        );
        $this->assertInstanceOf('Horde_Argv_Parser', $modular->createParser());
    }

    public function testCustomParser()
    {
        $modular = $this->_getDefault();
        $this->assertInstanceOf('Horde_Test_Stub_Parser', $modular->createParser());
    }


    /**
     * @expectedException Horde_Cli_Modular_Exception
     */
    public function testMissingModules()
    {
        $this->markTestSkipped('No Horde_Cli_Modular_Exception thrown if modules are missing. ');
        
        $modular = new Horde_Cli_Modular();
        $modular->getModules();        
    }

    public function testInvalidModules()
    {
        $this->expectException('Horde_Cli_Modular_Exception');
        $modular = new Horde_Cli_Modular(array('modules' => 1.0));
        $modular->getModules();
    }

    public function testObjectModules()
    {
        $modular = new Horde_Cli_Modular(
            array('modules' => new Horde_Cli_Modular_Modules(
                      array(
                          'directory' => __DIR__ . '/../fixtures/Module'
                      )
                  )
            )
        );
        $this->assertInstanceOf('Horde_Cli_Modular_Modules', $modular->getModules());
    }

    public function testStringModules()
    {
        $modular = new Horde_Cli_Modular(
            array(
                'modules' => Modules::class
            )
        );
        $this->assertInstanceOf(Horde_Cli_Modular_Modules::class, $modular->getModules());
    }

    public function testArrayModules()
    {
        $modular = new Horde_Cli_Modular(
            array(
                'modules' => array(
                    'directory' => __DIR__ . '/../fixtures/Module'
                ),
            )
        );
        $this->assertInstanceOf('Horde_Cli_Modular_Modules', $modular->getModules());
    }


    /**
     * @expectedException Horde_Cli_Modular_Exception
     */
    public function testMissingProviders()
    {
         $this->markTestSkipped('No Horde_Cli_Modular_Exception thrown if providers are missing. ');
        
        $modular = new Horde_Cli_Modular();
        $modular->getProvider();       
    }

    public function testInvalidProviders()
    {
        $this->expectException('Horde_Cli_Modular_Exception');
        $modular = new Horde_Cli_Modular(array('provider' => 1.0));
        $modular->getProvider();
    }

    public function testObjectProviders()
    {
        $modular = new Horde_Cli_Modular(
            array('provider' => new Horde_Cli_Modular_ModuleProvider(
                      array('prefix' => 'Test')
                  )
            )
        );
        $this->assertInstanceOf(
            'Horde_Cli_Modular_ModuleProvider', $modular->getProvider()
        );
    }

    public function testStringProviders()
    {
        $modular = new Horde_Cli_Modular(
            array(
                'provider' => 'Horde\\Cli\\Modular\\Test\\LibContent\\Stub\\Provider'
            )
        );
        $this->assertInstanceOf(
            'Horde_Cli_Modular_ModuleProvider', $modular->getProvider()
        );
    }

    public function testArrayProviders()
    {
        $modular = new Horde_Cli_Modular(
            array(
                'provider' => array(
                    'prefix' => 'Test'
                ),
            )
        );
        $this->assertInstanceOf(
            'Horde_Cli_Modular_ModuleProvider', $modular->getProvider()
        );
    }

    public function testGeneralUsage()
    {
        $modular = $this->_getDefault();
        $this->assertStringContainsString(
            'GLOBAL USAGE', $modular->createParser()->formatHelp()
        );
    }

    public function testBaseOption()
    {
        $modular = $this->_getDefault();
        $this->assertStringContainsString(
            '--something=SOMETHING', $modular->createParser()->formatHelp()
        );
    }

    public function testGroupTitle()
    {
        $modular = $this->_getDefault();
        $this->assertStringContainsString(
            'Test Group Title', $modular->createParser()->formatHelp()
        );
    }

    public function testGroupDescription()
    {
        $modular = $this->_getDefault();
        $this->assertStringContainsString(
            'Test Group Description', $modular->createParser()->formatHelp()
        );
    }

    public function testGroupOption()
    {
        $modular = $this->_getDefault();
        $this->assertStringContainsString(
            '--group=GROUP', $modular->createParser()->formatHelp()
        );
    }

    private function _getDefault()
    {
        return new Horde_Cli_Modular(
            array(
                'parser' => array(
                    'class' => 'Horde_Test_Stub_Parser',
                    'usage' => 'GLOBAL USAGE'
                ),
                'modules' => array(
                    'directory' => __DIR__ . '/../Stub/Module'
                ),
                'provider' => array(
                    'prefix' => 'Horde\\Cli\\Modular\\Test\\LibContent\\Stub\\Module\\'
                ),
            )
        );
    }
}
