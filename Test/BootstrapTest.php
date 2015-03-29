<?php
require '../application/configs/configs.php';
require '../application/bootstrap.php';

class BootstrapTest extends PHPUnit_Framework_TestCase
{
    public function testNullUrl()
    {
        unset($_GET['url']);
        $bt = new Bootstrap();
        $this->assertEmpty($bt->_url);
    }

    public function testParsedURL()
    {
        $_GET['url'] = 'test/xyz/klm';
        $bt = new Bootstrap();
        $this->assertEquals(array('test','xyz','klm'),$bt->_url);
    }

    public function testParsedURLwithEndSlash()
    {
        $_GET['url'] = 'test/xyz/klm/';
        $bt = new Bootstrap();
        $this->assertEquals(array('test','xyz','klm'),$bt->_url);
    }

    public function testParsedURLwithFile()
    {
        $_GET['url'] = 'test/xyz/klm/index.php';
        $bt = new Bootstrap();
        $this->assertEquals(array('test','xyz','klm','index.php'),$bt->_url);
    }

    public function routeProvider()
    {
        //url, controller, action, params
        return array(
            array(null,array('home','index',null)),
            array('mycontrol',array('mycontrol','index',null)),
            array('mycontrol/action',array('mycontrol','action',null)),
            array('mycontrol/action/',array('mycontrol','action',null)),
            array('mycontrol/action/param1',array('mycontrol','action',array('param1'))),
            array('mycontrol/action/param1/',array('mycontrol','action',array('param1'))),
            array('mycontrol/action/param1/param2',array('mycontrol','action',array('param1','param2'))),
        );
    }
    /**
     * @dataProvider routeProvider
     */
    public function testRouting($url,$expected)
    {
        $_GET['url'] = $url;
        $bt = new Bootstrap();
        $bt->routing();
        $this->assertEquals($expected,array($bt->_controller,$bt->_action,$bt->_params));
    }
}
