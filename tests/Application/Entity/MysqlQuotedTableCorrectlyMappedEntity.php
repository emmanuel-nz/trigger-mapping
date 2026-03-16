<?php

namespace Talleu\TriggerMapping\Tests\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Talleu\TriggerMapping\Attribute\Trigger;

#[ORM\Entity]
#[ORM\Table(name: '`mysql_quoted_table_correctly_mapped_entity`')]
#[Trigger(name: "quoted_table_correctly_mapped_trigger", on: ["UPDATE"], when: "BEFORE", scope: "ROW")]
class MysqlQuotedTableCorrectlyMappedEntity
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;
}