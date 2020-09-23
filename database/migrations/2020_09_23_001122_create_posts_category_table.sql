CREATE TABLE `post`
(
    `id`           int NOT NULL AUTO_INCREMENT,
    `title`        VARCHAR(255),
    `preview_text` TEXT         DEFAULT NULL,
    `detail_text`  TEXT         DEFAULT NULL,
    `author_id`    int          DEFAULT NULL,
    `category_id`  int          DEFAULT NULL,
    `status`       VARCHAR(255) DEFAULT '1',
    `edited`       BOOLEAN      DEFAULT false,
    `created_at`   DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   DATETIME     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

CREATE TABLE `category_post`
(
    `id`    int NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255),
    PRIMARY KEY (`id`)
);