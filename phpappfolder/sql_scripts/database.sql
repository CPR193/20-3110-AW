/*
 * SQL Database
 *
 * @package AWMain
 * @author 20-3110-AW - Edward
 */
 
CREATE DATABASE sms_db;

USE sms_db;

/*
 * Creates the Database Table
*/

CREATE TABLE sms_msg_table (
    source_sim int,
    email_address varchar(255),
    name varchar (255),
    message_content varchar(80)
);
