CREATE TABLE old_users(
id int,
user_email varchar( 255 ) ,
first_name varchar( 255 ) ,
last_name varchar( 255 )
);# MySQL returned an empty result set (i.e. zero rows).
INSERT INTO old_users
SELECT DISTINCT u.id, u.user_email, fn.meta_value AS first_name, ln.meta_value AS last_name
FROM wp_users AS u
LEFT JOIN wp_usermeta AS fn ON u.id = fn.user_id
AND fn.meta_key = 'first_name'
LEFT JOIN wp_usermeta AS ln ON u.id = ln.user_id
AND ln.meta_key = 'last_name'
WHERE fn.user_id =1# 1 row affected.