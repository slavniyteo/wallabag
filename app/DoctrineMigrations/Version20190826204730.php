<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Wallabag\CoreBundle\Doctrine\WallabagMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190826204730 extends WallabagMigration
{
    private $rules = [
        'host = "feedproxy.google.com"',
        'host = "feeds.reuters.com"',
        'pattern ~ "https?://www\\\.lemonde\\\.fr/tiny.*"'
    ];

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE ' . $this->getTable('ignore_origin_user_rule') . ' (id INT AUTO_INCREMENT NOT NULL, config_id INT DEFAULT NULL, rule VARCHAR(255) NOT NULL, INDEX IDX_BB05DA1224DB0683 (config_id), PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE ' . $this->getTable('ignore_origin_user_rule') . ' ADD CONSTRAINT FK_BB05DA1224DB0683 FOREIGN KEY (config_id) REFERENCES ' . $this->getTable('config') . ' (id)');

        $this->addSql('CREATE TABLE ' . $this->getTable('ignore_origin_instance_rule') . ' (id INT AUTO_INCREMENT NOT NULL, rule VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        
        foreach ($this->rules as $rule) {
            $this->addSql('INSERT INTO ' . $this->getTable('ignore_origin_instance_rule') . " (rule) VALUES ('" . $rule . "');");
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE ' . $this->getTable('ignore_origin_user_rule'));
        $this->addSql('DROP TABLE ' . $this->getTable('ignore_origin_instance_rule'));
    }
}
