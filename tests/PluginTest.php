<?php
/**
 * Phergie plugin for Pull excuses from bastard operator from hell (phergie-irc-plugin-react-bofh)
 *
 * @link https://github.com/phergie/phergie-irc-plugin-react-bofh for the canonical source repository
 * @copyright Copyright (c) 2015 Joe Ferguson (http://www.joeferguson.me)
 * @license http://phergie.org/license Simplified BSD License
 * @package Phergie\Irc\Plugin\React\BOFH
 */

namespace Phergie\Irc\Tests\Plugin\React\BOFH;

use Phake;
use Phergie\Irc\Bot\React\EventQueueInterface as Queue;
use Phergie\Irc\Plugin\React\Command\CommandEvent as Event;
use Phergie\Irc\Plugin\React\BOFH\Plugin;


/**
 * Tests for the Plugin class.
 *
 * @category Phergie
 * @package Phergie\Irc\Plugin\React\BOFH
 */
class PluginTest extends \PHPUnit_Framework_TestCase
{

    private $event;
    private $queue;
    private $emitter;
    private $logger;
    private $loop;
    private $plugin;
    protected function setUp()
    {
        $this->event = Phake::mock('\Phergie\Irc\Plugin\React\Command\CommandEvent');
        $this->queue = Phake::mock('\Phergie\Irc\Bot\React\EventQueueInterface');
        $this->emitter = Phake::mock('\Evenement\EventEmitterInterface');
        $this->logger = Phake::mock('\Psr\Log\LoggerInterface');
        $this->loop = Phake::mock('\React\EventLoop\LoopInterface');
        $this->plugin = $this->getPlugin();
    }

    protected function getPlugin()
    {
        $config = [];
        $plugin = new Plugin($config);
        $plugin->setEventEmitter($this->emitter);
        $plugin->setLogger($this->logger);
        $plugin->setLoop($this->loop);
        return $plugin;
    }

    public function testFullConfiguration()
    {
        $config = [];
        $plugin = new Plugin($config);
        $this->assertInstanceOf('Phergie\Irc\Plugin\React\BOFH\Plugin', $plugin);
    }

    /**
     * Tests that getSubscribedEvents() returns an array.
     */
    public function testGetSubscribedEvents()
    {
        $this->assertInternalType('array', $this->plugin->getSubscribedEvents());
    }

    public function testhandleBofhCommand()
    {
        Phake::when($this->event)->getSource()->thenReturn('#channel');
        $this->plugin->handleBofhCommand($this->event, $this->queue);

        Phake::verify($this->emitter)->emit('http.request', Phake::capture($params));
        $this->assertInternalType('array', $params);
        $this->assertCount(1, $params);
        $request = reset($params);
        $this->assertInstanceOf('WyriHaximus\Phergie\Plugin\Http\Request', $request);

        $config = $request->getConfig();
        $this->assertInternalType('array', $config);
        $this->assertArrayHasKey('resolveCallback', $config);
        $this->assertInternalType('callable', $config['resolveCallback']);
        $this->assertArrayHasKey('rejectCallback', $config);
        $this->assertInternalType('callable', $config['rejectCallback']);
    }

    /**
     * Tests handleBigstockHelp().
     */
    public function testhandleBofhHelpCommand()
    {
        Phake::when($this->event)->getCustomParams()->thenReturn([]);
        Phake::when($this->event)->getSource()->thenReturn('#channel');
        Phake::when($this->event)->getCommand()->thenReturn('PRIVMSG');
        $this->plugin->handleBofhHelpCommand($this->event, $this->queue);
        Phake::verify($this->queue, Phake::atLeast(1))->ircPrivmsg('#channel', $this->isType('string'));
    }
}
