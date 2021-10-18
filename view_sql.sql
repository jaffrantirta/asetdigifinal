CREATE VIEW inout_bonuses_complate_data AS
SELECT a.*, b.owner_id AS owner_id FROM inout_bonuses a
LEFT JOIN total_bonuses b ON b.id=a.total_bonus_id;

CREATE VIEW withdraws_complate_data AS
SELECT a.*, b.name AS user_name FROM withdraws a
LEFT JOIN users b ON b.id=a.user_id;

CREATE VIEW lisensi_upgrades_complate_data AS
select `a`.`id` AS `id`,`a`.`order_number` AS `order_number`,`a`.`date` AS `date`,`a`.`request_by` AS `request_by`,`a`.`current_lisensi` AS `current_lisensi`,`a`.`upgrade_to` AS `upgrade_to`,`a`.`diff_payment` AS `diff_payment`,`a`.`is_finish` AS `is_finish`,`a`.`payment_method` AS `payment_method`,`a`.`receipt_of_payment` AS `receipt_of_payment`,`b`.`name` AS `current_licence_name`,`c`.`name` AS `upgrade_to_name`,`d`.`name` AS `user_name` 
from (((`lisensi_upgrades` `a` 
left join `lisensies` `b` on(`b`.`id` = `a`.`current_lisensi`)) 
left join `lisensies` `c` on(`c`.`id` = `a`.`upgrade_to`)) 
left join `users` `d` on(`d`.`id` = `a`.`request_by`));

CREATE VIEW pin_register_complate_data AS
select `p`.`id` AS `id`,`p`.`pin` AS `pin`,`p`.`registered_by` AS `registered_by`,`p`.`used_by` AS `used_by`,`p`.`is_active` AS `is_active`,`p`.`registered_date` AS `registered_date`,`p`.`order_id` AS `order_id`,`u`.`id` AS `user_id`,`u`.`name` AS `user_name` 
from (`pin_register` `p` 
left join `users` `u` on(`u`.`id` = `p`.`used_by`));

CREATE VIEW sponsor_code_bonus_details_complate_data AS
select `a`.`id` AS `id`,`a`.`owner_id` AS `owner_id`,`a`.`balance` AS `balance`,`a`.`updated_at` AS `updated_at`,`b`.`date` AS `date`,`c`.`name` AS `user_name`,`d`.`name` AS `licence_name`,`b`.`belance` AS `balance_detail`,`b`.`percentage_at_the_time` AS `percentage_at_the_time` 
from (((`sponsor_code_bonuses` `a` 
left join `sponsor_code_bonus_details` `b` on(`b`.`sponsor_code_bonus_id` = `a`.`id`)) 
inner join `users` `c` on(`c`.`id` = `b`.`register_bonus_by`)) 
inner join `lisensies` `d` on(`d`.`id` = `b`.`lisensies_id`));

CREATE VIEW transfer_complate_date AS
select `t`.`id` AS `id`,`t`.`transfer_number` AS `transfer_number`,`t`.`send_by` AS `send_by`,`t`.`receive_by` AS `receive_by`,`t`.`amount` AS `amount`,`t`.`date` AS `date`,`us`.`id` AS `sender_id`,`us`.`name` AS `sender_name`,`ur`.`id` AS `receiver_id`,`ur`.`name` AS `receiver_name` 
from ((`transfers` `t` 
join `users` `us` on(`us`.`id` = `t`.`send_by`)) 
join `users` `ur` on(`ur`.`id` = `t`.`receive_by`));

CREATE VIEW turnover_details_complate_data AS
select `a`.`id` AS `id`,`a`.`turnover_id` AS `turnover_id`,`a`.`position` AS `position`,`a`.`user_id` AS `user_id`,`a`.`lisensi_id` AS `lisensi_id`,`a`.`price_at_the_time` AS `price_at_the_time`,`a`.`currency_at_the_time` AS `currency_at_the_time`,`a`.`date` AS `date`,`c`.`id` AS `register_id`,`c`.`name` AS `register_name`,`d`.`id` AS `owner_id`,`d`.`name` AS `owner_name`,`e`.`name` AS `lisensi_name` 
from ((((`turnover_details` `a` 
left join `turnovers` `b` on(`b`.`id` = `a`.`turnover_id`)) 
left join `users` `c` on(`c`.`id` = `a`.`user_id`)) 
left join `users` `d` on(`d`.`id` = `b`.`owner`)) 
left join `lisensies` `e` on(`e`.`id` = `a`.`lisensi_id`));

CREATE VIEW user_lisensies_complate_data AS
select `ul`.`id` AS `id`,`ul`.`order_id` AS `order_id`,`ul`.`lisensi_id` AS `lisensi_id`,`ul`.`owner` AS `owner`,`ul`.`is_active` AS `is_active`,`ul`.`date` AS `date`,`l`.`name` AS `lisensi_name`,`l`.`price` AS `lisensi_price`,`l`.`percentage` AS `percentage`,`u`.`name` AS `owner_name`,`u`.`id` AS `owner_id` 
from ((`user_lisensies` `ul` 
left join `users` `u` on(`u`.`id` = `ul`.`owner`)) 
left join `lisensies` `l` on(`l`.`id` = `ul`.`lisensi_id`));

CREATE VIEW customer_complate_date AS
select `f`.`left_belance` AS `left_belance`,`f`.`right_belance` AS `right_belance`,`e`.`balance` AS `balance`,`a`.`id` AS `id`,`a`.`name` AS `name`,`a`.`email` AS `email`,`a`.`email_verified_at` AS `email_verified_at`,`a`.`username` AS `username`,`a`.`password` AS `password`,`a`.`profile_picture` AS `profile_picture`,`a`.`role` AS `role`,`a`.`register_date` AS `register_date`,`a`.`secure_pin` AS `secure_pin`,`b`.`code` AS `code`,`d`.`name` AS `lisensi_name`, `c`.`is_active` AS `is_active_licence` 
from (((((`users` `a` 
left join `sponsor_codes` `b` on(`b`.`owner` = `a`.`id`)) 
left join `user_lisensies` `c` on(`c`.`owner` = `a`.`id`)) 
left join `lisensies` `d` on(`d`.`id` = `c`.`lisensi_id`)) 
left join `sponsor_code_bonuses` `e` on(`e`.`owner_id` = `a`.`id`)) 
left join `turnovers` `f` on(`f`.`owner` = `a`.`id`)) 
where `a`.`is_active` = 1;

CREATE VIEW sponsor_code_uses_complete_data AS
SELECT a.*, 
b.code AS code, 
c.id AS owner_id, 
c.name AS owner_code, 
d.id AS user_id, 
d.name AS user_code, 
f.id AS owner_lisensi_id,
f.name AS owner_lisensi_name, 
f.price AS owner_lisensi_price, 
f.percentage AS owner_percentage,
h.id AS user_lisensi_id,
h.name AS user_lisensi_name, 
h.price AS user_lisensi_price, 
h.percentage AS user_percentage
FROM sponsor_code_uses a 
LEFT JOIN sponsor_codes b ON b.id=a.sponsor_id 
LEFT JOIN users c ON c.id=b.owner 
LEFT JOIN users d ON d.id=a.used_by 
LEFT JOIN user_lisensies e ON e.owner=b.owner 
LEFT JOIN lisensies f ON f.id=e.lisensi_id 
LEFT JOIN user_lisensies g ON g.owner=d.id
LEFT JOIN lisensies h ON h.id=g.lisensi_id;

//-----> new 20/09

CREATE VIEW order_complete_data AS
SELECT a.*, b.name AS user_name FROM orders a
LEFT JOIN users b ON b.id=a.requested_by;

INSERT INTO `settings` (`id`, `key`, `content`) VALUES (NULL, 'dashboard_video_link', '{\"video 1\":\"xxxx\", \"video 2\":\"yyy\"}');
INSERT INTO `settings` (`id`, `key`, `content`) VALUES (NULL, 'dashboard_video_link', '{\"video 1\":\"xxxx\", \"video 2\":\"yyy\"}');

INSERT INTO `banners` (`id`, `name`, `picture`, `date`, `is_active`) VALUES (NULL, 'banner 1', 'banner.PNG', current_timestamp(), '1'), (NULL, 'banner 2', 'banner2.PNG', current_timestamp(), '1');

INSERT INTO `settings` (`id`, `key`, `content`) VALUES (NULL, 'icon_wa', 'xxx');

INSERT INTO `settings` (`id`, `key`, `content`) VALUES (NULL, 'minimum_withdraw', '25');

//---->new 22/09

CREATE VIEW members AS
SELECT 
a.*,
d.code AS code, 
e.balance AS sponsor_bonus,
(h.left_belance + h.right_belance) AS total_omset,
g.name AS lisensi_name,
g.is_active AS is_active_lisensi
FROM users a 
LEFT JOIN total_bonuses b ON b.owner_id=a.id 
LEFT JOIN sponsor_codes d ON d.owner=a.id 
LEFT JOIN sponsor_code_bonuses e ON e.owner_id=a.id 
LEFT JOIN user_lisensies f ON f.owner=a.id 
LEFT JOIN lisensies g ON g.id=f.lisensi_id
LEFT JOIN turnovers h ON h.owner=a.id
WHERE a.role = 'customer'

-- SELECT
-- sum(a.balance) AS total_pairing
-- FROM inout_bonuses_complate_data a
-- WHERE a.note = 'pairing bonus';

//--------> not

ALTER TABLE turnovers ADD is_active BOOLEAN NOT NULL DEFAULT FALSE AFTER updated_at;

ALTER TABLE `lisensi_upgrades` CHANGE `is_finish` `is_finish` INT(1) NOT NULL DEFAULT '0' COMMENT '0=pending 1=finish 2=reject';

INSERT INTO `settings` (`id`, `key`, `content`) VALUES (NULL, 'percentage_sponsor_bonus', '20');

CREATE VIEW history_balance AS
SELECT a.*, c.id AS user_id, c.name AS user_name FROM inout_bonuses a
LEFT JOIN total_bonuses b ON b.id=a.total_bonus_id
LEFT JOIN users c ON c.id=b.owner_id

