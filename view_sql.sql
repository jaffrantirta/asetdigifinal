CREATE VIEW inout_bonuses_complate_data AS
SELECT a.*, b.id AS owner_id FROM inout_bonuses a
LEFT JOIN total_bonuses b ON b.id=a.total_bonus_id;

CREATE VIEW withdraws_complate_data AS
SELECT a.*, b.name AS user_name FROM withdraws a
LEFT JOIN users b ON b.id=a.user_id;

CREATE VIEW lisensi_upgrades_complate_data AS
select `a`.`id` AS `id`,`a`.`order_number` AS `order_number`,`a`.`date` AS `date`,`a`.`request_by` AS `request_by`,`a`.`current_lisensi` AS `current_lisensi`,`a`.`upgrade_to` AS `upgrade_to`,`a`.`diff_payment` AS `diff_payment`,`a`.`is_finish` AS `is_finish`,`a`.`payment_method` AS `payment_method`,`a`.`receipt_of_payment` AS `receipt_of_payment`,`b`.`name` AS `current_licence_name`,`c`.`name` AS `upgrade_to_name`,`d`.`name` AS `user_name` 
from lisensi_upgrades a
LEFT JOIN `lisensies` `b` ON b.id=a.current_lisensi
left join `lisensies` `c` on(`c`.`id` = `a`.`upgrade_to`)) 
left join `users` `d` on(`d`.`id` = `a`.`request_by`));

CREATE VIEW pin_register_complate_data AS
select `p`.`id` AS `id`,`p`.`pin` AS `pin`,`p`.`registered_by` AS `registered_by`,`p`.`used_by` AS `used_by`,`p`.`is_active` AS `is_active`,`p`.`registered_date` AS `registered_date`,`p`.`order_id` AS `order_id`,`u`.`id` AS `user_id`,`u`.`name` AS `user_name` 
from (`pin_register` `p` 
left join `users` `u` on(`u`.`id` = `p`.`used_by`));

CREATE VIEW sponsor_code_bonus_detail_complate_data AS
select `d`.`code` AS `sponsor_code_name`,`a`.`id` AS `id`,`a`.`sponsor_code_bonus_id` AS `sponsor_code_bonus_id`,`a`.`register_bonus_by` AS `register_bonus_by`,`a`.`lisensies_id` AS `lisensies_id`,`a`.`currency_at_the_time` AS `currency_at_the_time`,`a`.`belance` AS `belance`,`a`.`date` AS `date`,`b`.`name` AS `user_name`,`c`.`name` AS `lisensi_name`,`c`.`percentage` AS `percentage_lisensi`,`a`.`percentage_at_the_time` AS `percentage_at_the_time` 
from (((`sponsor_code_bonus_details` `a` 
left join `users` `b` on(`b`.`id` = `a`.`register_bonus_by`)) 
left join `lisensies` `c` on(`c`.`id` = `a`.`lisensies_id`)) 
left join `sponsor_codes` `d` on(`d`.`owner` = `b`.`id`));

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

