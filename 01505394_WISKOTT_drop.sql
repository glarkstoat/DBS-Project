---------------------------- Dropping constraints, tables & sequences ------------------------------------------

DROP SEQUENCE seq_emp_ID; DROP SEQUENCE seq_ord_ID; DROP SEQUENCE seq_cust_ID; 
DROP SEQUENCE seq_sub_ID; DROP SEQUENCE seq_feature_ID;
DROP SEQUENCE seq_type_ID;

DROP TABLE employee CASCADE CONSTRAINTS;
DROP TABLE has_feature CASCADE CONSTRAINTS;
DROP TABLE rents CASCADE CONSTRAINTS;
DROP TABLE subsidiary CASCADE CONSTRAINTS;
DROP TABLE order_placed CASCADE CONSTRAINTS;
DROP TABLE feature;
DROP TABLE car CASCADE CONSTRAINTS;
DROP TABLE type CASCADE CONSTRAINTS;
DROP TABLE customer CASCADE CONSTRAINTS;
DROP TABLE make_model; 
DROP TABLE location;
DROP TABLE hasBoss CASCADE CONSTRAINTS;
DROP TABLE order_details CASCADE CONSTRAINTS;