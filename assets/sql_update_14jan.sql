

INSERT INTO `user_types` (`id`, `type`) VALUES ('5', 'Finance');
INSERT INTO `emp_list` (`id`, `empno`, `username`, `ou`, `bu`, `manager`, `location`, `status`, `password`, `email`, `joining_date`, `left_on`, `firstname`, `middlename`, `lastname`, `passport_no`, `passport_expiry_date`, `user_type`, `passport_copy`, `address1`, `address2`, `city`, `contact_no`, `alt_contact_no`, `emergency_no`, `dob`, `entity`, `manager_email`) VALUES (NULL, NULL, 'finance', NULL, NULL, NULL, NULL, '1', 'b9c9b331a8a5007cb2b766c6cd293372', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5', NULL, NULL, NULL, '849', NULL, NULL, NULL, NULL, '', '');

ALTER TABLE `destination_and_departure` CHANGE `late_checkin` `late_checkin` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `late_checkout` `late_checkout` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `hotel_bookings` CHANGE `late_checkin` `late_checkin` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `late_checkout` `late_checkout` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `hotel_bookings` ADD `request_id` INT(255) NOT NULL AFTER `hotel_id`;
/*ALTER TABLE `destination_and_departure` ADD `late_checkin` VARCHAR(11) NULL DEFAULT NULL AFTER `car_size`, ADD `late_checkout` VARCHAR(11) NULL DEFAULT NULL AFTER `late_checkin`;*/
