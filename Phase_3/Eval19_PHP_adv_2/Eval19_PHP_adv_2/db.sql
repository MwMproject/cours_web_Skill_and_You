CREATE TABLE `projet_meteo`.`meteo` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `date` DATE NOT NULL ,
    `period` VARCHAR(25) NOT NULL ,
    `city` VARCHAR(25) NOT NULL ,
    `resume` VARCHAR(100) NOT NULL ,
    `resume_id` INT NOT NULL ,
    `temp_min` INT NOT NULL ,
    `temp_max` INT NOT NULL ,
    `comment` TEXT NOT NULL ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
