CREATE TABLE `post`
(
    `id`              int NOT NULL AUTO_INCREMENT,
    `title`           VARCHAR(255),
    `slug`            VARCHAR(255),
    `preview_picture` VARCHAR(2048) DEFAULT NULL,
    `detail_picture`  VARCHAR(2048) DEFAULT NULL,
    `preview_text`    TEXT          DEFAULT NULL,
    `detail_text`     TEXT          DEFAULT NULL,
    `author_id`       int           DEFAULT NULL,
    `category_id`     int           DEFAULT NULL,
    `status`          VARCHAR(255)  DEFAULT '1',
    `edited`          BOOLEAN       DEFAULT false,
    `created_at`      DATETIME      DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      DATETIME      DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) CHARACTER SET utf8
  COLLATE utf8_unicode_ci;

CREATE TABLE `category_post`
(
    `id`              int NOT NULL AUTO_INCREMENT,
    `title`           VARCHAR(255),
    `slug`            VARCHAR(255),
    `preview_picture` VARCHAR(2048) DEFAULT NULL,
    `detail_picture`  VARCHAR(2048) DEFAULT NULL,
    `preview_text`    TEXT          DEFAULT NULL,
    `detail_text`     TEXT          DEFAULT NULL,
    `status`          VARCHAR(255)  DEFAULT '1',
    `created_at`      DATETIME      DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      DATETIME      DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) CHARACTER SET utf8
  COLLATE utf8_unicode_ci;