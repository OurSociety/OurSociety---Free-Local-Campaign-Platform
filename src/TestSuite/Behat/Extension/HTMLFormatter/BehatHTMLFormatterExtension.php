<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Extension\HTMLFormatter;

use emuse\BehatHTMLFormatter as emuse;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class BehatHTMLFormatterExtension extends emuse\BehatHTMLFormatterExtension
{
    /**
     * {@inheritdoc}. Override parent to replace definition class with our own.
     */
    public function load(ContainerBuilder $container, array $config) {
        $definition = new Definition(Formatter\BehatHTMLFormatter::class); // Use our class.
        $definition->addArgument($config['name']);
        $definition->addArgument($config['renderer']);
        $definition->addArgument($config['file_name']);
        $definition->addArgument($config['print_args']);
        $definition->addArgument($config['print_outp']);
        $definition->addArgument($config['loop_break']);
        $definition->addArgument('%paths.base%');

        $container->setDefinition('html.formatter', $definition)->addTag('output.formatter');
    }
}
