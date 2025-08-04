-- Table for vehicle manufacturers
CREATE TABLE `vehicle_maker` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL UNIQUE
);

-- Table for vehicles, linked to their maker
CREATE TABLE `vehicle` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `maker_id` INT NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `model` VARCHAR(255) NOT NULL,
    `top_speed` INT,
    `engine_type` VARCHAR(255),
    `engine_power` INT,
    `fuel_type` VARCHAR(255),
    `length` DECIMAL(10, 2),
    `width` DECIMAL(10, 2),
    `height` DECIMAL(10, 2),
    `weight` DECIMAL(10, 2),
    `number_of_seats` INT,
    `0_to_100_time` DECIMAL(10, 2),
    -- Foreign key to link to the vehicle_maker table
    FOREIGN KEY (`maker_id`) REFERENCES `vehicle_maker`(`id`) ON DELETE CASCADE
);