<?php

declare(strict_types=1);

namespace Talleu\TriggerMapping\Utils;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManagerInterface;

final class EntityFinder
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    private function unquote(string $value): string
    {
        // " : PostgreSQL, Oracle, SQLite, MySQL if the ANSI_QUOTES SQL mode is enabled, SQL Server if SET QUOTED_IDENTIFIER is ON
        // ` : MySQL, SQLite
        // [] : SQL Server, SQLite
        return trim($value, '"`[]');
    }

    public function findEntityFqcnForTable(string $tableName): ?string
    {
        $allMetadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        /** @var ClassMetadata<object> $metadata */
        foreach ($allMetadata as $metadata) {
            if ($this->unquote($metadata->getTableName()) === $tableName) {
                return $metadata->getName();
            }
        }

        return null;
    }

    public function findEntityFqcnForJoinTable(string $tableName): ?string
    {
        $allMetadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        /** @var ClassMetadata<object> $metadata */
        foreach ($allMetadata as $metadata) {
            foreach ($metadata->getAssociationMappings() as $assoc) {
                if (isset($assoc['joinTable']['name']) && $this->unquote($assoc['joinTable']['name']) === $tableName) {
                    return $metadata->getName();
                }
            }
        }

        return null;
    }
}
