<?php

declare(strict_types=1);

namespace Rector\Tests\Autodiscovery\Rector\Interface_\MoveInterfacesToContractNamespaceDirectoryRector\Source\ValueObject;

final class SameClassImplementEntity implements \Rector\Tests\Autodiscovery\Rector\Interface_\MoveInterfacesToContractNamespaceDirectoryRector\Source\Entity\RandomInterface
{
    public function __construct(\Rector\Tests\Autodiscovery\Rector\Interface_\MoveInterfacesToContractNamespaceDirectoryRector\Source\Entity\RandomInterface $random)
    {
    }
    public function returnAnother(): \Rector\Tests\Autodiscovery\Rector\Interface_\MoveInterfacesToContractNamespaceDirectoryRector\Source\Entity\RandomInterface
    {
    }
}
