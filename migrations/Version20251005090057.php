<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

use Webmozart\Assert\Assert;

use function dump;
use function file_get_contents;
use function var_dump;

final class Version20251005090057 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $sql = file_get_contents(__DIR__ . '/Resources/dump.sql');
        Assert::string($sql);
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
