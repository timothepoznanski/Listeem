mysql> desc lists;
+-------------+--------------+------+-----+---------+----------------+
| Field       | Type         | Null | Key | Default | Extra          |
+-------------+--------------+------+-----+---------+----------------+
| list_id     | int          | NO   | PRI | NULL    | auto_increment |
| list_name   | varchar(50)  | NO   |     | NULL    |                |
| list_date   | varchar(50)  | YES  |     | NULL    |                |
| date_access | varchar(20)  | YES  |     | NULL    |                |
| hidden      | int          | NO   |     | 0       |                |
+-------------+--------------+------+-----+---------+----------------+
6 rows in set (0,01 sec)

mysql> desc listsitems;
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| item_id   | int          | NO   | PRI | NULL    | auto_increment |
| list_id   | int          | NO   |     | NULL    |                |
| item      | varchar(700) | NO   |     | NULL    |                |
| important | int          | NO   |     | 0       |                |
| checked   | int          | NO   |     | 0       |                |
+-----------+--------------+------+-----+---------+----------------+
5 rows in set (0,00 sec)
