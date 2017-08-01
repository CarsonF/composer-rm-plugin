<?php

namespace Full\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Composer\Util\Filesystem;

class RmPlugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
    }

    public function onRun(Event $event)
    {
        $io = $event->getIO();

        $config = $event->getComposer()->getConfig();
        $vendor = $config->get('vendor-dir');
        $paths = (array) $config->get('rm-paths');

        $fs = new Filesystem();
        foreach ($paths as $path) {
            $abs = $fs->isAbsolutePath($path) ? $path : $vendor . DIRECTORY_SEPARATOR . $path;
            if (!file_exists($abs)) {
                $io->write("Skipped deleting <comment>$path</comment>", true, IOInterface::VERBOSE);

                continue;
            }
            $io->write("Deleting <comment>$path</comment>");
            $fs->remove($abs);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => 'onRun',
            ScriptEvents::POST_UPDATE_CMD => 'onRun',
        ];
    }
}
