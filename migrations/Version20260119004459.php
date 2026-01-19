<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260119004459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, service_type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price_total INT NOT NULL, price_platform_fee INT NOT NULL, notes TEXT DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, owner_id UUID NOT NULL, host_id UUID NOT NULL, pet_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_E00CEDDEB03A8386 ON booking (created_by_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE896DBBDE ON booking (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE7E3C61F9 ON booking (owner_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE1FB8D185 ON booking (host_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE966F7FB6 ON booking (pet_id)');
        $this->addSql('CREATE TABLE conversation (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, booking_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_8A8E26E9B03A8386 ON conversation (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E9896DBBDE ON conversation (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E93301C60 ON conversation (booking_id)');
        $this->addSql('CREATE TABLE conversation_participant (conversation_id UUID NOT NULL, user_id UUID NOT NULL, PRIMARY KEY (conversation_id, user_id))');
        $this->addSql('CREATE INDEX IDX_398016619AC0396 ON conversation_participant (conversation_id)');
        $this->addSql('CREATE INDEX IDX_39801661A76ED395 ON conversation_participant (user_id)');
        $this->addSql('CREATE TABLE host_profile (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, bio TEXT DEFAULT NULL, accepted_species JSON NOT NULL, services_offered JSON NOT NULL, has_garden BOOLEAN NOT NULL, has_children BOOLEAN NOT NULL, has_other_pets BOOLEAN NOT NULL, max_pets_at_once INT NOT NULL, is_verified BOOLEAN NOT NULL, verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, address_street VARCHAR(255) DEFAULT NULL, address_city VARCHAR(100) DEFAULT NULL, address_postal_code VARCHAR(20) DEFAULT NULL, address_country VARCHAR(2) DEFAULT NULL, address_latitude DOUBLE PRECISION DEFAULT NULL, address_longitude DOUBLE PRECISION DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, user_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_B6AB863EB03A8386 ON host_profile (created_by_id)');
        $this->addSql('CREATE INDEX IDX_B6AB863E896DBBDE ON host_profile (updated_by_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6AB863EA76ED395 ON host_profile (user_id)');
        $this->addSql('CREATE TABLE media (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, entity_type VARCHAR(50) NOT NULL, entity_id UUID NOT NULL, url VARCHAR(500) NOT NULL, filename VARCHAR(255) NOT NULL, mime_type VARCHAR(100) DEFAULT NULL, size_bytes INT DEFAULT NULL, is_primary BOOLEAN NOT NULL, caption VARCHAR(255) DEFAULT NULL, sort_order INT NOT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, user_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_6A2CA10CB03A8386 ON media (created_by_id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C896DBBDE ON media (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CA76ED395 ON media (user_id)');
        $this->addSql('CREATE INDEX idx_media_entity ON media (entity_type, entity_id)');
        $this->addSql('CREATE TABLE meet_and_greet (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, scheduled_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_video BOOLEAN NOT NULL, notes TEXT DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, booking_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_A8D71DA8B03A8386 ON meet_and_greet (created_by_id)');
        $this->addSql('CREATE INDEX IDX_A8D71DA8896DBBDE ON meet_and_greet (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_A8D71DA83301C60 ON meet_and_greet (booking_id)');
        $this->addSql('CREATE TABLE message (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, content TEXT NOT NULL, read_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, conversation_id UUID NOT NULL, sender_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_B6BD307FB03A8386 ON message (created_by_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F896DBBDE ON message (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F9AC0396 ON message (conversation_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FF624B39D ON message (sender_id)');
        $this->addSql('CREATE TABLE pet (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(100) NOT NULL, species VARCHAR(255) NOT NULL, breed VARCHAR(100) DEFAULT NULL, birth_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, weight_kg DOUBLE PRECISION DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, is_vaccinated BOOLEAN NOT NULL, is_neutered BOOLEAN NOT NULL, is_house_trained BOOLEAN NOT NULL, temperament TEXT DEFAULT NULL, behavior_notes TEXT DEFAULT NULL, routine TEXT DEFAULT NULL, medical_notes TEXT DEFAULT NULL, dietary_restrictions TEXT DEFAULT NULL, allergies TEXT DEFAULT NULL, dog_attributes JSON DEFAULT NULL, cat_attributes JSON DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, owner_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_E4529B85B03A8386 ON pet (created_by_id)');
        $this->addSql('CREATE INDEX IDX_E4529B85896DBBDE ON pet (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_E4529B857E3C61F9 ON pet (owner_id)');
        $this->addSql('CREATE TABLE review (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, rating SMALLINT NOT NULL, comment TEXT DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, booking_id UUID NOT NULL, author_id UUID NOT NULL, subject_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_794381C6B03A8386 ON review (created_by_id)');
        $this->addSql('CREATE INDEX IDX_794381C6896DBBDE ON review (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_794381C63301C60 ON review (booking_id)');
        $this->addSql('CREATE INDEX IDX_794381C6F675F31B ON review (author_id)');
        $this->addSql('CREATE INDEX IDX_794381C623EDC87 ON review (subject_id)');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(20) DEFAULT NULL, email_verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, status VARCHAR(255) NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON "user" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649896DBBDE ON "user" (updated_by_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT GENERATED BY DEFAULT AS IDENTITY NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE1FB8D185 FOREIGN KEY (host_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E93301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE conversation_participant ADD CONSTRAINT FK_398016619AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation_participant ADD CONSTRAINT FK_39801661A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE host_profile ADD CONSTRAINT FK_B6AB863EB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE host_profile ADD CONSTRAINT FK_B6AB863E896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE host_profile ADD CONSTRAINT FK_B6AB863EA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE meet_and_greet ADD CONSTRAINT FK_A8D71DA8B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE meet_and_greet ADD CONSTRAINT FK_A8D71DA8896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE meet_and_greet ADD CONSTRAINT FK_A8D71DA83301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B857E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C63301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C623EDC87 FOREIGN KEY (subject_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDEB03A8386');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE896DBBDE');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE7E3C61F9');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE1FB8D185');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE966F7FB6');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT FK_8A8E26E9B03A8386');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT FK_8A8E26E9896DBBDE');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT FK_8A8E26E93301C60');
        $this->addSql('ALTER TABLE conversation_participant DROP CONSTRAINT FK_398016619AC0396');
        $this->addSql('ALTER TABLE conversation_participant DROP CONSTRAINT FK_39801661A76ED395');
        $this->addSql('ALTER TABLE host_profile DROP CONSTRAINT FK_B6AB863EB03A8386');
        $this->addSql('ALTER TABLE host_profile DROP CONSTRAINT FK_B6AB863E896DBBDE');
        $this->addSql('ALTER TABLE host_profile DROP CONSTRAINT FK_B6AB863EA76ED395');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10CB03A8386');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10C896DBBDE');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10CA76ED395');
        $this->addSql('ALTER TABLE meet_and_greet DROP CONSTRAINT FK_A8D71DA8B03A8386');
        $this->addSql('ALTER TABLE meet_and_greet DROP CONSTRAINT FK_A8D71DA8896DBBDE');
        $this->addSql('ALTER TABLE meet_and_greet DROP CONSTRAINT FK_A8D71DA83301C60');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FB03A8386');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F896DBBDE');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F9AC0396');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE pet DROP CONSTRAINT FK_E4529B85B03A8386');
        $this->addSql('ALTER TABLE pet DROP CONSTRAINT FK_E4529B85896DBBDE');
        $this->addSql('ALTER TABLE pet DROP CONSTRAINT FK_E4529B857E3C61F9');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C6B03A8386');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C6896DBBDE');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C63301C60');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C6F675F31B');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C623EDC87');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649B03A8386');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649896DBBDE');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE conversation_participant');
        $this->addSql('DROP TABLE host_profile');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE meet_and_greet');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
