<?php

declare (strict_types=1);
namespace RectorPrefix20211031\Symplify\PackageBuilder\DependencyInjection\CompilerPass;

use RectorPrefix20211031\Symfony\Component\Console\Command\Command;
use RectorPrefix20211031\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use RectorPrefix20211031\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20211031\Symplify\PackageBuilder\Console\Command\CommandNaming;
/**
 * @see \Symplify\PackageBuilder\Tests\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPassTest
 */
final class NamelessConsoleCommandCompilerPass implements \RectorPrefix20211031\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function process($containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            $definitionClass = $definition->getClass();
            if ($definitionClass === null) {
                continue;
            }
            if (!\is_a($definitionClass, \RectorPrefix20211031\Symfony\Component\Console\Command\Command::class, \true)) {
                continue;
            }
            $commandName = \RectorPrefix20211031\Symplify\PackageBuilder\Console\Command\CommandNaming::classToName($definitionClass);
            $definition->addMethodCall('setName', [$commandName]);
        }
    }
}
