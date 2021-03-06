<?php

/**
 * @file
 * Contains \Drupal\Console\Core\EventSubscriber\DefaultValueEventListener.
 */

namespace Drupal\Console\Core\EventSubscriber;

use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Console\Command\Command;
use Drupal\Console\Core\Utils\ConfigurationManager;

/**
 * Class DefaultValueEventListener
 *
 * @package Drupal\Console\Core\EventSubscriber
 */
class DefaultValueEventListener implements EventSubscriberInterface
{
    /**
     * @var ConfigurationManager
     */
    protected $configurationManager;

    /**
     * @var array
     */
    private $skipCommands = [
        'self-update',
        'list',
        'chain',
        'drush'
    ];

    /**
     * DefaultValueEventListener constructor.
     *
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(
        ConfigurationManager $configurationManager
    ) {
        $this->configurationManager = $configurationManager;
    }

    /**
     * @param ConsoleCommandEvent $event
     */
    public function setDefaultValues(ConsoleCommandEvent $event)
    {
        /* @var Command $command */
        $command = $event->getCommand();
        $configuration = $this->configurationManager
            ->getConfiguration();

        if (in_array($command->getName(), $this->skipCommands)) {
            return;
        }

        $inputDefinition = $command->getDefinition();
        $input = $event->getInput();
        $commandConfigKey = sprintf(
            'application.default.commands.%s',
            str_replace(':', '.', $command->getName())
        );
        $defaults = $configuration->get($commandConfigKey);
        $defaultOptions = array_key_exists('options', $defaults)?$defaults['options']:[];
        $defaultValues = [];
        if ($defaultOptions) {
            $reflection = new \ReflectionObject($input);
            $prop = $reflection->getProperty('tokens');
            $prop->setAccessible(true);
            $tokens = $prop->getValue($input);
            foreach ($defaultOptions as $key => $defaultValue) {
                $option = $inputDefinition->getOption($key);
                if ($input->getOption($key)) {
                    continue;
                }
                if ($option->acceptValue()) {
                    $defaultValues[] = sprintf(
                        '--%s=%s',
                        $key,
                        $defaultValue
                    );
                    continue;
                }
                $defaultValues[] = sprintf(
                    '--%s',
                    $key
                );
            }
            $prop->setValue(
                $input,
                array_unique(array_merge($tokens, $defaultValues))
            );
        }

        $defaultArguments = array_key_exists('arguments', $defaults)?$defaults['arguments']:[];
        foreach ($defaultArguments as $key => $defaultValue) {
            if ($input->getArgument($key)) {
                continue;
            }
            if ($argument = $inputDefinition->getArgument($key)) {
                $argument->setDefault($defaultValue);
            }
        }
    }

    /**
     * @{@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [ConsoleEvents::COMMAND => 'setDefaultValues'];
    }
}
