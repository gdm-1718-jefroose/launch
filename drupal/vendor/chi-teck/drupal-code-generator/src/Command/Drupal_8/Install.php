<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:install command.
 */
class Install extends BaseGenerator {

  protected $name = 'd8:install';
  protected $description = 'Generates an install file';
  protected $alias = 'install';
  protected $label = 'Install file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $this->collectVars($input, $output, Utils::defaultQuestions());
    $this->addFile()
      ->path('{machine_name}.install')
      ->template('d8/install.twig');
  }

}
