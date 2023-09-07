<?php

class DatabaseHelper
{
    // Since the connection details are constant, define them as const
    // We can refer to constants like e.g. DatabaseHelper::username
    const username = 'a01505394'; // use a + your matriculation number
    const password = 'dbs20'; // use your oracle db password
    const con_string = 'oracle-lab.cs.univie.ac.at:1521/lab';  //on almighty "lab" is sufficient

    // Since we need only one connection object, it can be stored in a member variable.
    // $conn is set in the constructor.
    protected $conn;

    // Create connection in the constructor
    public function __construct()
    {
        try {
            // Create connection with the command oci_connect(String(username), String(password), String(connection_string))
            // The @ sign avoids the output of warnings
            // It could be helpful to use the function without the @ symbol during developing process
            $this->conn = @oci_connect(
                DatabaseHelper::username,
                DatabaseHelper::password,
                DatabaseHelper::con_string
            );

            //check if the connection object is != null
            if (!$this->conn) {
                // die(String(message)): stop PHP script and output message:
                die("DB error: Connection can't be established!");
            }

        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }

    // Used to clean up
    public function __destruct()
    {
        // clean up
        @oci_close($this->conn);
    }

    //////////------------------- INSERT STATEMENTS ------------------- ///////////

    public function insertIntoEmployee($first_name, $last_name, $phone_nr, $sub_ID)
    {
        $sql = "INSERT INTO EMPLOYEE(FIRST_NAME, LAST_NAME, PHONE_NR, SUB_ID) 
                VALUES ('{$first_name}', '{$last_name}', '{$phone_nr}', '{$sub_ID}')";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }

    public function insertIntoSubsidiary($street_name, $street_nr, $zip_code)
    {
        $sql = "INSERT INTO SUBSIDIARY(STREET_NAME, STREET_NR, ZIP_CODE) 
                VALUES ('{$street_name}', '{$street_nr}', '{$zip_code}')";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }

    public function insertIntoLocation($zip_code, $city)
    {
        $sql = "INSERT INTO LOCATION(ZIP_CODE, CITY) 
                VALUES ('{$zip_code}', '{$city}')";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }

    public function insertIntoCustomer($licence_nr, $first_name, $last_name, $phone_nr)
    {
        $sql = "INSERT INTO CUSTOMER(LICENCE_NR, FIRST_NAME, LAST_NAME, PHONE_NR) 
                VALUES ('{$licence_nr}', '{$first_name}', '{$last_name}', '{$phone_nr}')";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }

    public function insertIntoOrder($e_ID, $car_ID, $sub_ID, $customer_ID)
    {
        $errorcode = 0;

        // The SQL string
        $sql = 'BEGIN P_INSERT_ORDER(:e_ID, :car_ID, :sub_ID, :customer_ID, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        //  Bind the parameters
        @oci_bind_by_name($statement, ':e_ID', $e_ID);
        @oci_bind_by_name($statement, ':car_ID', $car_ID);
        @oci_bind_by_name($statement, ':sub_ID', $sub_ID);
        @oci_bind_by_name($statement, ':customer_ID', $customer_ID);

        @oci_bind_by_name($statement, ':errorcode', $errorcode);

        // Execute Statement
        @oci_execute($statement);

        //Clean Up
        @oci_free_statement($statement);

        //$errorcode == 1 => success
        //$errorcode != 1 => Oracle SQL related errorcode;



        return $errorcode;
    }

    //////////------------------- QUERIES ------------------- ///////////

    public function selectFromEmployeeWhere($e_ID, $sub_ID, $first_name, $last_name)
    {
        $sql = "
		SELECT * FROM EMPLOYEE
            WHERE E_ID = '{$e_ID}'
            OR SUB_ID = '{$sub_ID}'
            OR FIRST_NAME = '{$first_name}'
            OR LAST_NAME = '{$last_name}'
            ORDER BY E_ID ASC";

        $statement = @oci_parse($this->conn, $sql);
        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res;
    }

    public function selectFromCustomerWhere($customer_ID, $first_name, $last_name)
    {
        $sql = "
		SELECT * FROM CUSTOMER
            WHERE CUSTOMER_ID = '{$customer_ID}'
            OR FIRST_NAME = '{$first_name}'
            OR LAST_NAME = '{$last_name}'
            ORDER BY CUSTOMER_ID ASC";

        $statement = @oci_parse($this->conn, $sql);
        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res;
    }

    public function selectFromCarWhere($make, $model, $type_name)
    {
        $sql = "
			SELECT * FROM CAR
			NATURAL JOIN MAKE_MODEL
			NATURAL JOIN TYPE
			    WHERE TYPE_NAME LIKE '%{$type_name}%'
			    AND MAKE LIKE '%{$make}%'
			    AND MODEL LIKE '%{$model}%'
			ORDER BY MAKE, MODEL ASC";

        $statement = @oci_parse($this->conn, $sql);
        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res;
    }

    public function selectFromFeatureWhere($make, $model)
    {
        $sql = "
			SELECT * FROM HAS_FEATURE
			NATURAL JOIN FEATURE
			NATURAL JOIN MAKE_MODEL
			WHERE MAKE LIKE '%{$make}%'
			AND MODEL LIKE '%{$model}%'
			ORDER BY MAKE, MODEL ASC";

        $statement = @oci_parse($this->conn, $sql);
        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res;
    }

    public function selectFromOrderDetails($order_ID, $e_ID, $customer_ID)
    {
        $sql = "
			SELECT * FROM ORDER_PLACED
			NATURAL JOIN ORDER_DETAILS
			NATURAL JOIN RENTS
			WHERE ORDER_ID = ('{$order_ID}')
			OR E_ID = ('{$e_ID}')
			OR CUSTOMER_ID = ('{$customer_ID}')
			ORDER BY ORDER_ID ASC";

        $statement = @oci_parse($this->conn, $sql);
        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res;
    }

    public function selectFromSubWhere($street_name, $street_nr, $zip_code, $city)
    {
        $sql = "
			SELECT * FROM SUBSIDIARY 
			NATURAL JOIN LOCATION
			WHERE STREET_NAME LIKE '%{$street_name}%'
			AND STREET_NR LIKE '%{$street_nr}%'
			AND ZIP_CODE LIKE '%{$zip_code}%'
			AND CITY LIKE '%{$city}%'
			ORDER BY ZIP_CODE ASC";

        $statement = @oci_parse($this->conn, $sql);
        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res;
    }

    // This function creates and executes a SQL select statement and returns an array as the result
    // 2-dimensional array: the result array contains nested arrays (each contains the data of a single row)
    public function selectAvgPriceOrder()
    {
        // Define the sql statement string
        // Notice that the parameters $person_id, $surname, $name in the 'WHERE' clause
        $sql = "		
		SELECT ROUND(AVG(price),2) AS average_price_of_order 
		FROM order_placed";

        $statement = @oci_parse($this->conn, $sql);
        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res;
    }

    //////////------------------- Delete Functions ------------------- ///////////

    // This function uses a SQL procedure to delete a person and returns an errorcode (&errorcode == 1 : OK)
    public function deleteEmployee($e_ID)
    {
        $errorcode = 0;

        // The SQL string
        $sql = 'BEGIN P_DELETE_EMPLOYEE(:e_ID, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        //  Bind the parameters
        @oci_bind_by_name($statement, ':e_ID', $e_ID);
        @oci_bind_by_name($statement, ':errorcode', $errorcode);

        // Execute Statement
        @oci_execute($statement);

        //Clean Up
        @oci_free_statement($statement);

        //$errorcode == 1 => success
        //$errorcode != 1 => Oracle SQL related errorcode;
        return $errorcode;
    }

    public function deleteCustomer($customer_ID)
    {
        $errorcode = 0;

        // The SQL string
        $sql = 'BEGIN P_DELETE_CUSTOMER(:customer_ID, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        //  Bind the parameters
        @oci_bind_by_name($statement, ':customer_ID', $customer_ID);
        @oci_bind_by_name($statement, ':errorcode', $errorcode);

        // Execute Statement
        @oci_execute($statement);

        //Clean Up
        @oci_free_statement($statement);

        //$errorcode == 1 => success
        //$errorcode != 1 => Oracle SQL related errorcode;
        return $errorcode;
    }

    // This function uses a SQL procedure to delete a person and returns an errorcode (&errorcode == 1 : OK)
    public function deleteType($type_name)
    {
        $errorcode = 0;

        // The SQL string
        $sql = 'BEGIN P_DELETE_TYPE(:type_name, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        //  Bind the parameters
        @oci_bind_by_name($statement, ':type_name', $type_name);
        @oci_bind_by_name($statement, ':errorcode', $errorcode);

        // Execute Statement
        @oci_execute($statement);

        //Clean Up
        @oci_free_statement($statement);

        //$errorcode == 1 => success
        //$errorcode != 1 => Oracle SQL related errorcode;
        return $errorcode;
    }

    // This function uses a SQL procedure to delete a person and returns an errorcode (&errorcode == 1 : OK)
    public function deleteMakeModel($make, $model)
    {
        $errorcode = 0;

        // The SQL string
        $sql = 'BEGIN P_DELETE_MAKE_MODEL(:make, :model, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        //  Bind the parameters
        @oci_bind_by_name($statement, ':make', $make);
        @oci_bind_by_name($statement, ':model', $model);
        @oci_bind_by_name($statement, ':errorcode', $errorcode);

        // Execute Statement
        @oci_execute($statement);

        //Clean Up
        @oci_free_statement($statement);

        //$errorcode == 1 => success
        //$errorcode != 1 => Oracle SQL related errorcode;
        return $errorcode;
    }

    // This function uses a SQL procedure to delete a person and returns an errorcode (&errorcode == 1 : OK)
    public function deleteSubsidiary($street_name, $street_nr)
    {
        $errorcode = 0;

        // The SQL string
        $sql = 'BEGIN P_DELETE_SUBSIDIARY(:street_name, :street_nr, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        //  Bind the parameters
        @oci_bind_by_name($statement, ':street_name', $street_name);
        @oci_bind_by_name($statement, ':street_nr', $street_nr);
        @oci_bind_by_name($statement, ':errorcode', $errorcode);

        // Execute Statement
        @oci_execute($statement);

        //Clean Up
        @oci_free_statement($statement);

        //$errorcode == 1 => success
        //$errorcode != 1 => Oracle SQL related errorcode;
        return $errorcode;
    }

    //////////------------------- Update Functions ------------------- ///////////

    public function updateEmployee($e_ID, $new_phone_nr, $new_sub_ID)
    {
        $sql = "
			UPDATE EMPLOYEE 
			SET PHONE_NR = '{$new_phone_nr}', 
			SUB_ID = '{$new_sub_ID}'
			WHERE E_ID = '{$e_ID}'";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }

    public function updateCustomer($customer_ID, $new_licence_nr, $new_phone_nr)
    {
        $sql = "
			UPDATE CUSTOMER 
			SET LICENCE_NR = '{$new_licence_nr}', 
			PHONE_NR = '{$new_phone_nr}'
			WHERE CUSTOMER_ID = '{$customer_ID}'";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }

    public function updateSubsidiary($sub_ID, $new_street_name, $new_street_nr, $new_zip_code)
    {
        $sql = "
			UPDATE SUBSIDIARY 
			SET STREET_NAME = '{$new_street_name}', 
			STREET_NR = '{$new_street_nr}',
			ZIP_CODE = '{$new_zip_code}'
			WHERE SUB_ID = '{$sub_ID}'";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }

    public function updateSubsidiaryTOTAL()
    {
        $sql = "
			UPDATE SUBSIDIARY 
			SET EMPLOYEES = (
			    SELECT COUNT(*)
			    FROM EMPLOYEE
			    WHERE SUBSIDIARY.SUB_ID = EMPLOYEE.SUB_ID)";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);

        $sql = "
			UPDATE SUBSIDIARY 
			SET RENTED_CARS_ATM = (
			    WITH TEMP_RESULT AS ( 
			        SELECT * FROM RENTS
			        NATURAL JOIN ORDER_DETAILS
			     )
			    SELECT COUNT(*)
			    FROM TEMP_RESULT
			    WHERE SUBSIDIARY.SUB_ID = TEMP_RESULT.SUB_ID
			    AND ((SELECT CURRENT_DATE FROM DUAL) BETWEEN START_D AND END_D))";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);

        $sql = "
			UPDATE SUBSIDIARY 
			SET TURNOVER = (
			    WITH TEMP_RESULT AS ( 
			        SELECT * FROM ORDER_PLACED
			        NATURAL JOIN RENTS
			     )
			    SELECT SUM(PRICE)
			    FROM TEMP_RESULT
			    WHERE SUBSIDIARY.SUB_ID = TEMP_RESULT.SUB_ID)";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);

        return $success;
    }

    public function updateCustomerTOTAL()
    {
        $sql = "
			UPDATE CUSTOMER 
			SET ORDERS = (
			    SELECT COUNT(*)
			    FROM ORDER_DETAILS
			    NATURAL JOIN RENTS
			    WHERE CUSTOMER.CUSTOMER_ID = ORDER_DETAILS.CUSTOMER_ID)";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);

        return $success;
    }

    public function updateOrderTOTAL()
    {
        $sql = "
            UPDATE ORDER_PLACED 
			SET PRICE = (
			    WITH TEMP_RESULT AS ( 
			        SELECT * FROM RENTS
			        NATURAL JOIN CAR
			        NATURAL JOIN MAKE_MODEL
			        NATURAL JOIN ORDER_DETAILS
			     )
			    SELECT ((TRUNC(END_D) - TRUNC(START_D)) * SUM(PRICE_PER_DAY))
			    FROM TEMP_RESULT
			    WHERE ORDER_PLACED.ORDER_ID = TEMP_RESULT.ORDER_ID
			    GROUP BY END_D, START_D)";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);

        return $success;
    }

    public function updateEmployeeTOTAL()
    {
        $sql = "
			UPDATE EMPLOYEE 
			SET TURNOVER = (
			    SELECT SUM(PRICE)
			    FROM ORDER_PLACED
			    WHERE EMPLOYEE.E_ID = ORDER_PLACED.E_ID)";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);

        return $success;
    }
}