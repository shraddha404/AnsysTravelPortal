/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  root
 * Created: 19 Jan, 2019
 */
ALTER TABLE `destination_and_departure` CHANGE `late_checkin` `late_checkin` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `late_checkout` `late_checkout` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `hotel_bookings` CHANGE `late_checkin` `late_checkin` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `late_checkout` `late_checkout` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `hotel_bookings` ADD `request_id` INT(255) NOT NULL AFTER `hotel_id`;


