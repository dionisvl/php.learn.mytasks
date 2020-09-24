CREATE TABLE `users`
(
    `id`       int NOT NULL AUTO_INCREMENT,
    `name`     VARCHAR(255),
    `password` VARCHAR(255),
    `email`    VARCHAR(255),
    `is_admin` BOOLEAN DEFAULT false,
    PRIMARY KEY (`id`)
) CHARACTER SET utf8
  COLLATE utf8_unicode_ci;

CREATE TABLE `tasks`
(
    `id`     int NOT NULL AUTO_INCREMENT,
    `name`   VARCHAR(255),
    `email`  VARCHAR(255),
    `text`   TEXT,
    `status` VARCHAR(255) DEFAULT 'NEW',
    `edited` BOOLEAN      DEFAULT false,
    PRIMARY KEY (`id`)
) CHARACTER SET utf8
  COLLATE utf8_unicode_ci;


#admin with SHA3-512 salted password = 123
INSERT INTO `users` (`id`, `name`, `password`, `email`, `is_admin`)
VALUES (1, 'admin',
        '7ef937e2e76df7517e4c9662b9fae45b9c177c8d41b03d85c7a7e3e69d8345b36a6b0864678cb871ffee31582d8a60450d72d9793955e9c381e0130863ddd35a',
        'admin@admin.admin', true)