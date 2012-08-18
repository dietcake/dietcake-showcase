<?php
require_once dirname(__DIR__).'/router.php';

class RouterTest extends PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        define('APP_URL', 'http://example.com/');
        define('APP_BASE_PATH', '/');
    }

    public function test_url()
    {
        $_SERVER['REQUEST_URI'] = 'http://example.com/';
        $this->assertEquals('http://example.com/', url(''));

        $_SERVER['REQUEST_URI'] = 'http://example.com/foo/bar';
        $this->assertEquals('http://example.com/foo/bar', url(''));

        $_SERVER['REQUEST_URI'] = 'http://example.com/foo/bar?hoge';
        $this->assertEquals('http://example.com/foo/bar?hoge', url(''));

        $_SERVER['REQUEST_URI'] = 'http://example.com/foo/bar?hoge=100';
        $this->assertEquals('http://example.com/foo/bar?hoge=100', url(''));

        $_SERVER['REQUEST_URI'] = 'http://example.com/foo/bar?hoge=100&foo=200';
        $this->assertEquals('http://example.com/foo/bar?hoge=100&foo=200', url(''));

        $_SERVER['REQUEST_URI'] = 'http://example.com/foo/bar?hoge=100&foo=200';
        $this->assertEquals('http://example.com/foo/bar?hoge=100&foo=200&bar=300', url('', array('bar' => 300)));

        $_SERVER['REQUEST_URI'] = 'http://example.com/foo/bar?hoge';
        $this->assertEquals('http://example.com/foo/bar?hoge=&foo=200', url('', array('foo' => 200))); // http_build_query の仕様で = がついてしまう

        // REQUEST_URI に含まれるパラメータを url 関数の引数で指定したとき、url 関数の引数が優先される
        $_SERVER['REQUEST_URI'] = 'http://example.com/foo/bar?hoge=100&foo=200';
        $this->assertEquals('http://example.com/foo/bar?hoge=100&foo=400&bar=300', url('', array('bar' => 300, 'foo' => 400)));

        // scheme がないとき
        $_SERVER['REQUEST_URI'] = 'example.com';
        $this->assertEquals('example.com', url(''));

        // host がないとき
        $_SERVER['REQUEST_URI'] = '';
        $this->assertEquals('', url(''));

        $_SERVER['REQUEST_URI'] = 'foo';
        $this->assertEquals('foo', url(''));

        $_SERVER['REQUEST_URI'] = '/foo/bar';
        $this->assertEquals('/foo/bar', url(''));

        $_SERVER['REQUEST_URI'] = '/foo/bar?hoge=1000';
        $this->assertEquals('/foo/bar?hoge=1000', url(''));
    }

    public function test_url_02()
    {
        $this->assertEquals('http://example.com/', url('/'));
        $this->assertEquals('http://example.com/?foo=100', url('/', array('foo' => 100)));
    }

    public function test_url_03()
    {
        $this->assertEquals('http://example.net/', url('http://example.net/'));
        $this->assertEquals('https://example.net/', url('https://example.net/'));
        $this->assertEquals('http://example.net/?foo=100', url('http://example.net/', array('foo' => 100)));
    }

    public function test_url_04()
    {
        $this->assertEquals('#content-id', url('#content-id'));
        $this->assertEquals('#content-id', url('#content-id', array('foo' => 100)));
    }

    public function test_url_05()
    {
        $this->assertEquals('?foo=100', url('?foo=100'));
        $this->assertEquals('?foo=100', url('?foo=100', array('bar' => 200)));
    }

    public function test_url_06()
    {
        $this->assertEquals('/top/index', url('top/index'));
        $this->assertEquals('/top/index?foo=100', url('top/index', array('foo' => 100)));
    }
}
