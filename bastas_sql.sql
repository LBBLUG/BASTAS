CREATE DATABASE IF NOT EXISTS BASTAS;

USE BASTAS;

CREATE TABLE IF NOT EXISTS BASTAS.Notes (
    notes_id int auto_increment primary key,
    notes varchar(500) charset utf8,
    main_id int
    ) engine=InnoDB default charset latin1;
    
CREATE TABLE IF NOT EXISTS BASTAS.Recipients (
    main_id int auto_increment primary key,
    lastname varchar(30) charset utf8,
    firstname varchar(30) charset utf8,
    gender varchar(1) charset utf8,
    home_phone varchar(13) charset utf8,
    cell_phone varchar(13) charset utf8,
    address_id int,
    route_no varchar(10) charset utf8
    ) engine=InnoDB default charset latin1;
    
CREATE TABLE IF NOT EXISTS BASTAS.Gifts (
    gift_id int auto_increment primary key,
    gift_no int,
    description varchar(500) charset utf8,
    size varchar(20) charset utf8,
    main_id int,
    status_id int
    ) engine=InnoDB default charset latin1;
    
CREATE TABLE IF NOT EXISTS BASTAS.Recip_Address (
    recip_address_id int auto_increment primary key,
    street_address varchar(50) charset utf8,
    apt_no varchar(10) charset utf8,
    neighborhood varchar(50) charset utf8,
    city varchar(50) charset utf8,
    state varchar(2) charset utf8,
    zip_code varchar(10) charset utf8,
    main_id int
    ) engine=InnoDB default charset latin1;
    
CREATE TABLE IF NOT EXISTS BASTAS.Gift_Status (
    status_id int auto_increment primary key,
    status varchar(50) charset utf8
    ) engine=InnoDB default charset latin1;
    
CREATE TABLE IF NOT EXISTS BASTAS.Giver (
    giver_id int auto_increment primary key,
    lastname varchar(30) charset utf8,
    firstname varchar(30) charset utf8,
    email varchar(150) charset utf8,
    phone_home varchar(13) charset utf8,
    phone_cell varchar(13) charset utf8,
    address_street varchar(50) charset utf8,
    apt_no varchar(10) charset utf8,
    city varchar(50) charset utf8,
    state varchar(2) charset utf8,
    zip_code varchar(10) charset utf8,
    wishes_anon boolean,
    gift_id int
    ) engine=InnoDB default charset latin1;
    
CREATE TABLE IF NOT EXISTS BASTAS.Delivery_Info (
    delivery_id int auto_increment primary key,
    person_name varchar(60) charset utf8,
    person_phone varchar(10) charset utf8,
    gift_id int
    ) engine=InnoDB default charset latin1;
    
CREATE TABLE IF NOT EXISTS BASTAS.Users (
    user_id int auto_increment primary key,
    last_name varchar(30) charset utf8,
    first_name varchar(30) charset utf8,
    company varchar(100) charset utf8,
    uname varchar(100) charset utf8,
    passw char(128),
    email varchar(150) charset utf8
    ) engine=InnoDB default charset latin1;
    
CREATE TABLE IF NOT EXISTS BASTAS.Permission_Mstr (
    perm_mstr_id int auto_increment primary key,
    user_id int,
    perm_type_id int,
    perm_group_id int
    ) engine=InnoDB default charset latin1;

CREATE TABLE IF NOT EXISTS BASTAS.Permission_Group (
    perm_group_id int auto_increment primary key,
    description varchar(30) charset utf8
    ) engine=InnoDB default charset latin1;

CREATE TABLE IF NOT EXISTS BASTAS.Permission_Type (
    perm_type_id int auto_increment primary key,
    type varchar(20) charset utf8
    ) engine=InnoDB default charset latin1;
    
    
CREATE TABLE IF NOT EXISTS BASTAS.User_Group (
    group_id int auto_increment primary key,
    group_name varchar(25) charset utf8,
    user_id int
    ) engine=InnoDB default charset latin1;

INSERT INTO BASTAS.Permission_Type SET type='Add';
INSERT INTO BASTAS.Permission_Type SET type='View';
INSERT INTO BASTAS.Permission_Type SET type='Edit';
INSERT INTO BASTAS.Permission_Type SET type='Delete';
INSERT INTO BASTAS.Permission_Type SET type='Print';

INSERT INTO BASTAS.Permission_Group SET description='Giver';
INSERT INTO BASTAS.Permission_Group SET description='Users';
INSERT INTO BASTAS.Permission_Group SET description='Groups';
INSERT INTO BASTAS.Permission_Group SET description='Gifts';
INSERT INTO BASTAS.Permission_Group SET description='Recipients';
INSERT INTO BASTAS.Permission_Group SET description='Recipient Addresses';
INSERT INTO BASTAS.Permission_Group SET description='Gift Status';
INSERT INTO BASTAS.Permission_Group SET description='Delivery Info';
INSERT INTO BASTAS.Permission_Group SET description='Notes';