<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See license.txt for license details.
 */

namespace Ergonode\AttributeUnit\Tests\Domain\Factory;

use Ergonode\Attribute\Domain\Command\CreateAttributeCommand;
use Ergonode\AttributeUnit\Domain\Entity\UnitAttribute;
use Ergonode\Attribute\Domain\ValueObject\AttributeType;
use Ergonode\AttributeUnit\Domain\Factory\UnitAttributeFactory;
use Ergonode\Core\Domain\ValueObject\TranslatableString;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 */
class UnitAttributeFactoryTest extends TestCase
{
    /**
     * @var CreateAttributeCommand|MockObject
     */
    private $createCommand;

    protected function setUp()
    {
        $this->createCommand = $this->createMock(CreateAttributeCommand::class);
        $this->createCommand->method('getLabel')->willReturn($this->createMock(TranslatableString::class));
        $this->createCommand->method('getHint')->willReturn($this->createMock(TranslatableString::class));
        $this->createCommand->method('getPlaceholder')->willReturn($this->createMock(TranslatableString::class));
        $this->createCommand->method('getParameter')->willReturn('UNIT');
    }

    /**
     */
    public function testIsSupported(): void
    {
        $strategy = new UnitAttributeFactory();
        $this->assertTrue($strategy->isSupported(new AttributeType(UnitAttribute::TYPE)));
    }

    /**
     */
    public function testIsNotSupported(): void
    {
        $strategy = new UnitAttributeFactory();
        $this->assertFalse($strategy->isSupported(new AttributeType('NOT-MATH')));
    }

    /**
     */
    public function testCreate(): void
    {
        $this->createCommand->method('hasParameter')->willReturn('true');
        $strategy = new UnitAttributeFactory();
        $result = $strategy->create($this->createCommand);

        $this->assertInstanceOf(UnitAttribute::class, $result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateWithoutParameter(): void
    {
        $strategy = new UnitAttributeFactory();
        $strategy->create($this->createCommand);
    }
}
