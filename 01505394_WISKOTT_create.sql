---------------------------------------- Table creation ---------------------------------------------------------
CREATE TABLE location (
    zip_code INT PRIMARY KEY,
    city VARCHAR(30));

CREATE TABLE subsidiary (
    sub_ID INT PRIMARY KEY,
    street_name VARCHAR(30),
    street_nr INT CHECK(street_nr > 0),
    zip_code INT,
    employees INT DEFAULT 0, -- calculated via update
    cars_in_inventory INT DEFAULT 0, -- calculated via update
    rented_cars_atm INT DEFAULT 0, -- calculated via update
    turnover REAL DEFAULT 0,
    CONSTRAINT fk_loc_sub FOREIGN KEY (zip_code) REFERENCES location(zip_code) ON DELETE CASCADE);

CREATE TABLE employee (
    e_ID INT PRIMARY KEY,
    first_name VARCHAR(30),
    last_name VARCHAR(30) NOT NULL,
    phone_nr VARCHAR(30),
    sub_ID INT NOT NULL,
    turnover INT DEFAULT 0, -- calculated via update
    CONSTRAINT fk_loc_emp FOREIGN KEY (sub_ID) REFERENCES subsidiary(sub_ID) ON DELETE CASCADE);

CREATE TABLE type (
    type_ID INT PRIMARY KEY,
    type_name VARCHAR(30));

CREATE TABLE make_model (
    make VARCHAR(30),
    model VARCHAR(30),
    price_per_day REAL CHECK(price_per_day > 0),
    type_ID INT,
    PRIMARY KEY(make, model),
    CONSTRAINT fk_type_ID_make FOREIGN KEY (type_ID) REFERENCES type(type_ID) ON DELETE CASCADE);

CREATE TABLE car (
    car_ID INT,
    sub_ID INT,
    make VARCHAR(30),
    model VARCHAR(30),
    mileage INT,
    consumption INT,
    PRIMARY KEY(car_ID, sub_ID),
    CONSTRAINT fk_loc_car FOREIGN KEY (sub_ID) REFERENCES subsidiary(sub_ID) ON DELETE CASCADE,
    CONSTRAINT fk_make_model_car FOREIGN KEY (make, model) REFERENCES make_model(make, model) ON DELETE CASCADE);    

CREATE TABLE feature (
    feature_ID INT PRIMARY KEY,
    description VARCHAR(30));   

CREATE TABLE order_placed (
    order_ID INT PRIMARY KEY,
    e_ID INT,
    price REAL DEFAULT 0, -- calculated via update
    CONSTRAINT fk_eid_order FOREIGN KEY (e_ID) REFERENCES employee(e_ID) ON DELETE SET NULL);

CREATE TABLE customer (
    customer_ID INT PRIMARY KEY,
    licence_nr VARCHAR(30) UNIQUE,
    first_name VARCHAR(30),
    last_name VARCHAR(30),
    phone_nr VARCHAR(30) UNIQUE,
    orders INT DEFAULT 0,
    gender VARCHAR(30)); -- calculated via update

CREATE TABLE hasBoss (
    e_ID_1 INT,
    e_ID_2 INT,
    PRIMARY KEY(e_ID_1, e_ID_2),
    CONSTRAINT fk_eID1_boss FOREIGN KEY (e_ID_1) REFERENCES employee(e_ID) ON DELETE CASCADE,
    CONSTRAINT fk_eID2_boss FOREIGN KEY (e_ID_2) REFERENCES employee(e_ID) ON DELETE CASCADE);

CREATE TABLE has_feature (
    type_ID INT,
    feature_ID INT,
    PRIMARY KEY(type_ID, feature_ID)
    ,CONSTRAINT fk_type_ID_feat FOREIGN KEY (type_ID) REFERENCES type(type_ID) ON DELETE CASCADE
    ,CONSTRAINT fk_feat FOREIGN KEY (feature_ID) REFERENCES feature(feature_ID) ON DELETE CASCADE);

CREATE TABLE rents (
    car_ID INT,
    sub_ID INT,
    order_ID INT,
    PRIMARY KEY(car_ID, sub_ID, order_ID)
    ,CONSTRAINT fk_car_rents FOREIGN KEY (car_ID, sub_ID) REFERENCES car(car_ID, sub_ID) ON DELETE CASCADE 
    ,CONSTRAINT fk_ord_rents FOREIGN KEY (order_ID) REFERENCES order_placed(order_ID) ON DELETE CASCADE
    ); 

CREATE TABLE order_details (
    order_ID INT PRIMARY KEY,
    customer_ID INT,
    start_d TIMESTAMP,
    end_d TIMESTAMP,
    CONSTRAINT fk_cust_orcus FOREIGN KEY (customer_ID) REFERENCES customer(customer_ID) ON DELETE SET NULL   
    ,CONSTRAINT fk_ord_orcus FOREIGN KEY (order_ID) REFERENCES order_placed(order_ID) ON DELETE CASCADE);

------------------------------------- Sequences & Triggers ------------------------------------------------------------------
CREATE SEQUENCE seq_sub_ID -- sequence for subsidiary ID
    START WITH 1
    MINVALUE 1
    INCREMENT BY 1
    CACHE 100;
CREATE SEQUENCE seq_emp_ID -- sequence for employee ID
    START WITH 1
    MINVALUE 1
    INCREMENT BY 1
    CACHE 100;
CREATE SEQUENCE seq_ord_ID -- sequence for order_placed ID
    START WITH 1
    MINVALUE 1
    INCREMENT BY 1
    CACHE 100;
CREATE SEQUENCE seq_cust_ID -- sequence for customer ID
    START WITH 1
    MINVALUE 1
    INCREMENT BY 1
    CACHE 100;
CREATE SEQUENCE seq_feature_ID -- sequence for feature_ID
    START WITH 1
    MINVALUE 1
    INCREMENT BY 1
    CACHE 100;
CREATE SEQUENCE seq_type_ID -- sequence for subsIDiary ID
    START WITH 1
    MINVALUE 1
    INCREMENT BY 1
    CACHE 100;

CREATE OR REPLACE TRIGGER trig_type_ID
 BEFORE INSERT ON type
 FOR EACH ROW
 BEGIN
    SELECT seq_type_ID.nextval
    INTO :new.type_ID
    FROM dual;
 END;
/
CREATE OR REPLACE TRIGGER trig_sub_ID
 BEFORE INSERT ON subsidiary
 FOR EACH ROW
 BEGIN
    SELECT seq_sub_ID.nextval
    INTO :new.sub_ID
    FROM dual;
 END;
/
CREATE OR REPLACE TRIGGER trig_emp_ID
 BEFORE INSERT ON employee
 FOR EACH ROW
 BEGIN
    SELECT seq_emp_ID.nextval
    INTO :new.e_ID
    FROM dual;
 END;
/
CREATE OR REPLACE TRIGGER trig_cust_ID
 BEFORE INSERT ON customer
 FOR EACH ROW
 BEGIN
    SELECT seq_cust_ID.nextval
    INTO :new.customer_ID
    FROM dual;
 END;
/
CREATE OR REPLACE TRIGGER trig_ord_ID -- trigger for order_ID
 BEFORE INSERT ON order_placed
 FOR EACH ROW
 BEGIN
    SELECT seq_ord_ID.nextval
    INTO :new.order_ID
    FROM dual;
 END;
/
CREATE OR REPLACE TRIGGER trig_feature_ID -- trigger for feature_ID
 BEFORE INSERT ON feature
 FOR EACH ROW
 BEGIN
    SELECT seq_feature_ID.nextval
    INTO :new.feature_ID
    FROM dual;
 END;
/

---------------------------------------------- Procedures ---------------------------------------------------

CREATE OR REPLACE PROCEDURE P_DELETE_EMPLOYEE (
    P_E_ID IN EMPLOYEE.E_ID%TYPE,
    P_ERROR_CODE OUT NUMBER) 
AS
BEGIN
    DELETE FROM EMPLOYEE WHERE P_E_ID = EMPLOYEE.E_ID;
    
    P_ERROR_CODE := SQL%ROWCOUNT;
    IF (P_ERROR_CODE = 1)
    THEN
      COMMIT;
    ELSE
      ROLLBACK;
    END IF;
    EXCEPTION
    WHEN OTHERS
    THEN
      P_ERROR_CODE := SQLCODE;
  END P_DELETE_EMPLOYEE;
/

CREATE OR REPLACE PROCEDURE P_DELETE_CUSTOMER (
    P_CUSTOMER_ID IN CUSTOMER.CUSTOMER_ID%TYPE,
    P_ERROR_CODE OUT NUMBER) 
AS
BEGIN
    DELETE FROM CUSTOMER WHERE P_CUSTOMER_ID = CUSTOMER.CUSTOMER_ID;
    
    P_ERROR_CODE := SQL%ROWCOUNT;
    IF (P_ERROR_CODE = 1)
    THEN
      COMMIT;
    ELSE
      ROLLBACK;
    END IF;
    EXCEPTION
    WHEN OTHERS
    THEN
      P_ERROR_CODE := SQLCODE;
  END P_DELETE_CUSTOMER;
/

CREATE OR REPLACE PROCEDURE P_DELETE_TYPE (
    P_TYPE_NAME IN TYPE.TYPE_NAME%TYPE,
    P_ERROR_CODE OUT NUMBER) 
AS
BEGIN
    DELETE FROM TYPE WHERE P_TYPE_NAME = TYPE.TYPE_NAME;
    
    P_ERROR_CODE := SQL%ROWCOUNT;
    IF (P_ERROR_CODE = 1)
    THEN
      COMMIT;
    ELSE
      ROLLBACK;
    END IF;
    EXCEPTION
    WHEN OTHERS
    THEN
      P_ERROR_CODE := SQLCODE;
  END P_DELETE_TYPE;
/

CREATE OR REPLACE PROCEDURE P_DELETE_MAKE_MODEL (
    P_MAKE IN MAKE_MODEL.MAKE%TYPE,
    P_MODEL IN MAKE_MODEL.MODEL%TYPE,
    P_ERROR_CODE OUT NUMBER) 
AS
BEGIN
    DELETE FROM MAKE_MODEL WHERE P_MAKE = MAKE_MODEL.MAKE AND P_MODEL = MAKE_MODEL.MODEL;
    
    P_ERROR_CODE := SQL%ROWCOUNT;
    IF (P_ERROR_CODE = 1)
    THEN
      COMMIT;
    ELSE
      ROLLBACK;
    END IF;
    EXCEPTION
    WHEN OTHERS
    THEN
      P_ERROR_CODE := SQLCODE;
  END P_DELETE_MAKE_MODEL;
/

CREATE OR REPLACE PROCEDURE P_DELETE_SUBSIDIARY (
    P_STREET_NAME IN SUBSIDIARY.STREET_NAME%TYPE,
    P_STREET_NR IN SUBSIDIARY.STREET_NR%TYPE,
    P_ERROR_CODE OUT NUMBER) 
AS
BEGIN
    DELETE FROM SUBSIDIARY WHERE P_STREET_NAME = SUBSIDIARY.STREET_NAME AND P_STREET_NR = SUBSIDIARY.STREET_NR; 
    
    P_ERROR_CODE := SQL%ROWCOUNT;
    IF (P_ERROR_CODE = 1)
    THEN
      COMMIT;
    ELSE
      ROLLBACK;
    END IF;
    EXCEPTION
    WHEN OTHERS
    THEN
      P_ERROR_CODE := SQLCODE;
  END P_DELETE_SUBSIDIARY;
/

-- Adds the appropriate rows to order_details and rents if a new order is placed. Necessary for various updates
CREATE OR REPLACE PROCEDURE P_INSERT_ORDER (
    P_E_ID IN EMPLOYEE.E_ID%TYPE,
    P_CAR_ID IN CAR.CAR_ID%TYPE,
    P_SUB_ID IN SUBSIDIARY.SUB_ID%TYPE,
    P_CUSTOMER_ID IN CUSTOMER.CUSTOMER_ID%TYPE,
    P_ERROR_CODE OUT NUMBER)
IS
BEGIN
    INSERT INTO ORDER_PLACED (E_ID) VALUES (P_E_ID);
    
    INSERT INTO ORDER_DETAILS (ORDER_ID, CUSTOMER_ID, START_D, END_D)
    WITH TEMP_RESULT AS (SELECT ORDER_ID FROM ORDER_PLACED ORDER BY ORDER_ID DESC FETCH FIRST ROW ONLY) -- most recently added order
    SELECT ORDER_ID, P_CUSTOMER_ID, TO_DATE('2020-6-20 18:45:18', 'yyyy/mm/dd hh24:mi:ss'), TO_DATE('2020-7-5 18:45:18', 'yyyy/mm/dd hh24:mi:ss')  FROM TEMP_RESULT, DUAL; -- Chosen in accordance to the live demo
    
    INSERT INTO RENTS (CAR_ID, SUB_ID, ORDER_ID)
    WITH TEMP_RESULT AS (SELECT ORDER_ID FROM ORDER_PLACED ORDER BY ORDER_ID DESC FETCH FIRST ROW ONLY) -- most recently added order
    SELECT P_CAR_ID, P_SUB_ID, ORDER_ID FROM TEMP_RESULT, DUAL;
    
    P_ERROR_CODE := SQL%ROWCOUNT;
    IF (P_ERROR_CODE = 1)
    THEN
        COMMIT;
    ELSE
        ROLLBACK;
    END IF;
    EXCEPTION
    WHEN OTHERS
    THEN
       P_ERROR_CODE := SQLCODE;
END P_INSERT_ORDER;
/

---------------------------------------------- Updates ---------------------------------------------------
-- Executed in the Java-Application and used in the DB-Helper of the PHP-Application
/*
UPDATE subsidiary -- updates the total number of employee in each subsidiary
    SET employees = (
    SELECT COUNT(*)
    FROM employee     
    WHERE subsidiary.sub_ID = employee.sub_ID);

UPDATE subsidiary -- updates the total number of car in the inventory of each subsidiary
    SET (cars_in_inventory) = (
    SELECT COUNT(*)
    FROM car     
    WHERE subsidiary.sub_ID = car.sub_ID);

UPDATE subsidiary -- updates the total number of rented car (which are rented right now) for each subsidiary
    SET (rented_cars_atm) = (
    
    WITH temp_result AS (SELECT * 
                         FROM rents
                         NATURAL JOIN order_details)  
    SELECT COUNT(*)
    FROM temp_result    
    WHERE subsidiary.sub_ID = temp_result.sub_ID
    AND ((SELECT CURRENT_DATE FROM DUAL) BETWEEN start_d AND end_d));

UPDATE customer -- updates the total amount of order_placedplaced by each customer
    SET (orders) = (
    SELECT COUNT(*)
    FROM order_details
    NATURAL JOIN rents
    WHERE customer.customer_ID = order_details.customer_ID);

UPDATE order_placed -- Calculates of the total price of an order_placed
    SET (price) = (
    
    WITH temp_result AS (SELECT * 
                        FROM rents
                        Natural JOIN car
                        NATURAL JOIN make_model
                        NATURAL JOIN order_details)
    
    SELECT ((trunc(end_d) - trunc(start_d)) * SUM(price_per_day))
    FROM temp_result
    WHERE order_placed.order_ID = temp_result.order_ID group by end_d, start_d);

UPDATE subsidiary -- updates the total turnover produced by each subsidiary
    SET (turnover) = (
    
    WITH temp_result AS (SELECT *
                         FROM order_placed
                         NATURAL JOIN rents) 
    SELECT SUM(price)
    FROM temp_result     
    WHERE subsidiary.sub_ID = temp_result.sub_ID);
    
UPDATE employee -- updates the turnover acrued by each employee
    SET (turnover) = (
    SELECT SUM(price)
    FROM order_placed     
    WHERE employee.e_ID = order_placed.e_ID);
select * from employee;
*/
---------------------------------------------- Queries --------------------------------------------------
-- All cars with a certain type
SELECT make, model, price_per_day, type_name, car_ID, sub_ID, description FROM car
NATURAL JOIN make_model
NATURAL JOIN type
NATURAL JOIN has_feature
NATURAL JOIN feature
WHERE DESCRIPTION = 'Climate Control' 
OR DESCRIPTION = '3 Doors' 
order by car_ID, sub_ID ASC;

-- List of features for every car type
select * from type natural join has_feature natural join feature order by type_name;

-- All car that have not yet been rented by any customer
SELECT * FROM car WHERE (car_ID, sub_ID) NOT IN (SELECT car_ID, sub_ID FROM rents);

-- Alternative
(SELECT car_ID, sub_ID FROM car)
MINUS  
(SELECT car_ID, sub_ID FROM car NATURAL JOIN rents);
SELECT * FROM car NATURAL LEFT OUTER JOIN rents WHERE order_ID IS NULL;

-- Average price of an order_placed
SELECT ROUND(AVG(price),2) AS average_price_of_order 
FROM order_placed;

-- Every subsidiary in Vienna
select * from subsidiary natural join location WHERE city LIKE '%Wien%';

-- Name & Total sum of turnover accrued by each employee, having more than one completed order_placed
WITH temp_result AS (
    SELECT order_placed.e_ID, SUM(price) AS total_sum
    FROM order_placed 
    GROUP BY order_placed.e_ID 
    HAVING count(*) > 1)
SELECT e_ID, first_name, last_name, total_sum FROM temp_result 
NATURAL JOIN employee 
ORDER BY total_sum DESC;