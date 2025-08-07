-- Insert sample vehicle makers
INSERT INTO `vehicle_maker` (`name`) VALUES
  ('Toyota'),
  ('Ford'),
  ('BMW'),
  ('Tesla'),
  ('Honda');

-- Insert sample vehicles, linking to makers by their IDs
-- Assume vehicle_maker IDs are assigned in order: 1=Toyota, 2=Ford, 3=BMW, 4=Tesla, 5=Honda

-- Toyota Vehicles
INSERT INTO `vehicle` (
    `maker_id`, `type`, `model`, `top_speed`, `engine_type`, `engine_power`, `fuel_type`, `length`, `width`, `height`, `weight`, `number_of_seats`, `zero_to_hundred_time`
) VALUES
  (1, 'Sedan', 'Camry', 210, 'Inline-4', 203, 'Petrol', 4881.00, 1840.00, 1445.00, 1500.00, 5, 8.2),
  (1, 'SUV', 'RAV4', 200, 'Inline-4', 203, 'Petrol', 4600.00, 1855.00, 1685.00, 1650.00, 5, 8.5);

-- Ford Vehicles
INSERT INTO `vehicle` (
    `maker_id`, `type`, `model`, `top_speed`, `engine_type`, `engine_power`, `fuel_type`, `length`, `width`, `height`, `weight`, `number_of_seats`, `zero_to_hundred_time`
) VALUES
  (2, 'SUV', 'Explorer', 180, 'V6', 290, 'Petrol', 5050.00, 2000.00, 1780.00, 2100.00, 7, 7.0),
  (2, 'Pickup', 'F-150', 175, 'V8', 400, 'Petrol', 5890.00, 2029.00, 1961.00, 2200.00, 5, 6.2);

-- BMW Vehicles
INSERT INTO `vehicle` (
    `maker_id`, `type`, `model`, `top_speed`, `engine_type`, `engine_power`, `fuel_type`, `length`, `width`, `height`, `weight`, `number_of_seats`, `zero_to_hundred_time`
) VALUES
  (3, 'Sedan', '330i', 250, 'Inline-4 Turbo', 255, 'Petrol', 4709.00, 1827.00, 1435.00, 1470.00, 5, 5.6),
  (3, 'SUV', 'X5', 243, 'V6 Turbo', 335, 'Diesel', 4922.00, 2004.00, 1745.00, 2130.00, 5, 5.5);

-- Tesla Vehicles
INSERT INTO `vehicle` (
    `maker_id`, `type`, `model`, `top_speed`, `engine_type`, `engine_power`, `fuel_type`, `length`, `width`, `height`, `weight`, `number_of_seats`, `zero_to_hundred_time`
) VALUES
  (4, 'Sedan', 'Model S', 322, 'Electric', 1020, 'Electric', 4970.00, 1964.00, 1445.00, 2196.00, 5, 2.1),
  (4, 'SUV', 'Model X', 250, 'Electric', 1020, 'Electric', 5052.00, 1999.00, 1684.00, 2486.00, 7, 2.6);

-- Honda Vehicles
INSERT INTO `vehicle` (
    `maker_id`, `type`, `model`, `top_speed`, `engine_type`, `engine_power`, `fuel_type`, `length`, `width`, `height`, `weight`, `number_of_seats`, `zero_to_hundred_time`
) VALUES
  (5, 'Sedan', 'Accord', 205, 'Inline-4 Turbo', 192, 'Petrol', 4900.00, 1862.00, 1450.00, 1460.00, 5, 7.6),
  (5, 'SUV', 'CR-V', 190, 'Inline-4 Turbo', 190, 'Petrol', 4635.00, 1855.00, 1679.00, 1550.00, 5, 8.2);