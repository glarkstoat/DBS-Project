package dbs_tut;
import java.io.*; 
import java.sql.*;
import java.util.ArrayList;
import java.nio.charset.StandardCharsets; 
import java.nio.file.Files; 
import java.nio.file.Path; 
import java.nio.file.Paths; 
import java.util.*;


import com.opencsv.CSVReader;

// The DatabaseHelper class encapsulates the communication with our database
class DatabaseHelper {
    // Database connection info
    private static final String DB_CONNECTION_URL = "jdbc:oracle:thin:@oracle-lab.cs.univie.ac.at:1521:lab";
    private static final String USER = "a01505394"; 
    private static final String PASS = "dbs20"; 
    
    // The name of the class loaded from the ojdbc14.jar driver file
    //private static final String CLASSNAME = "oracle.jdbc.driver.OracleDriver";

    // We need only one Connection and one Statement during the execution => class variable
    private static Statement stmt;
    private static Connection con;
    
  //---------------------------------------------------------
  //------------------CREATE CONNECTION ------------------------------------------------------------------------
  //---------------------------------------------------------
  
    DatabaseHelper() {
        try {
            //Loads the class into the memory
            //Class.forName(CLASSNAME);

            // establish connection to database
            con = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
            stmt = con.createStatement();

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    
    int getRandomNumberInRange(int min, int max) {

        Random r = new Random();
        return r.ints(min, max).findFirst().getAsInt();
    }
  
  //---------------------------------------------------------
    //------------------INSERTs and CSV Imports ---------------------------
    //---------------------------------------------------------
    
    void importAll() {
        try { 
        	importLocation(); 
    		importSubsidiary();
    		importEmployee(); 
    		importType();
    		importMakeModel();
    		importCar(); 
    		importFeature(); 
    		importOrderPlaced(); 
    		importCustomer();
    		importHasBoss(); 
    		importHasFeature(); 
    		importRents(); 
    		importOrderDetails();
    		updateAll();
        } catch (Exception e) {
            System.err.println("Error at: importAll\nmessage: " + e.getMessage());
        }
    }
    
      void insertIntoLocation(String zip_code, String city) {
          try { 
              String sql = "INSERT INTO location(zip_code, city) VALUES ('" +
                      zip_code +
                      "', '" +
                      city +
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoLocation\nmessage: " + e.getMessage());
          }
      }
      
      void importLocation() {
  		
  		try {
  			
  	        CSVReader reader = new CSVReader(new FileReader("C:\\Users\\f\\Dropbox\\CompSci\\DBS\\Milestones\\Datasets\\locations.txt"));

  	        String[] nextline;
  	        while((nextline = reader.readNext()) != null) {
  	            if(nextline != null) {
  	            	insertIntoLocation(nextline[0], nextline[1]);
  	            }
  	        }
  	    }
  	    catch(Exception e) {
  	        System.out.println(e);
  	    }    	
  	}
     
      void insertIntoSubsidiary(String street_name, String street_nr, String zip_code) {
          try {
              String sql = "INSERT INTO subsidiary(street_name, street_nr, zip_code) VALUES ('" +
                      street_name +
                      "', '" +
                      street_nr +
                      "', '" +
                      zip_code +
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoSubsidiary\nmessage: " + e.getMessage());
          }
      }
  	
  		void importSubsidiary() {
  		
  		try {
  			
  	        CSVReader reader = new CSVReader(new FileReader("C:\\Users\\f\\Dropbox\\CompSci\\DBS\\Milestones\\Datasets\\subsidiaries_addresses.txt"));

  	        String[] nextline;
  	        while((nextline = reader.readNext()) != null) {
  	            if(nextline != null) {
  	            	insertIntoSubsidiary(nextline[0], nextline[1], nextline[2]);
  	            }
  	        }
  	    }
  	    catch(Exception e) {
  	        System.out.println(e);
  	    }    	
  	}
  	
      void insertIntoEmployee(String first_name, String last_name, String phone_nr, int sub_ID) {
          try { 
              String sql = "INSERT INTO employee(first_name, last_name, phone_nr, sub_ID) VALUES ('" +
                      first_name + 
                      "', '" +
                      last_name +
                      "', '" +
                      phone_nr +
                      "', '" +
                      sub_ID +
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoEmployees\nmessage: " + e.getMessage());
          }
      }
      
      void importEmployee() {
  		
  		try {
  			
  	        CSVReader reader = new CSVReader(new FileReader("C:\\Users\\f\\Dropbox\\CompSci\\DBS\\Milestones\\Datasets\\employees.txt"));

  	        String[] nextline;
  	        ArrayList<Integer> IDs = selectSubIDs();
  	        while((nextline = reader.readNext()) != null) {
  	            if(nextline != null) {
  	            	int ran = getRandomNumberInRange(0,IDs.size());
  	            	insertIntoEmployee(nextline[0], nextline[1], nextline[2], IDs.get(ran)); 
  	            }
  	        }
  	    }
  	    catch(Exception e) {
  	        System.out.println(e);
  	    }    	
  	}
      
      void insertIntoType(String type_name) {
          try { 
              String sql = "INSERT INTO type(type_name) VALUES ('" +
                      type_name +
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoTypes\nmessage: " + e.getMessage());
          }
      }
      
      void importType() {
			
    		try {
    			
                CSVReader reader = new CSVReader(new FileReader("C:\\Users\\f\\Dropbox\\CompSci\\DBS\\Milestones\\Datasets\\types.txt"));

                String[] nextline;
                while((nextline = reader.readNext()) != null) {
                    if(nextline != null) {
                    	insertIntoType(nextline[0]);
                    }
                }
    		}
            catch(Exception e) {
                System.out.println(e);
            }
        }
      
      void insertIntoMakeModel(String make, String model, String price_per_day, String type_ID) {
          try { 
              String sql = "INSERT INTO make_model(make, model, price_per_day, type_ID) VALUES ('" +
                      make + 
                      "', '" +
                      model +
                      "', '" +
                      price_per_day +
                      "', '" +
                      type_ID +
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoMakeModel\nmessage: " + e.getMessage());
          }
      }
      
      void importMakeModel() {
			
    		try {
    			
                CSVReader reader = new CSVReader(new FileReader("C:\\Users\\f\\Dropbox\\CompSci\\DBS\\Milestones\\Datasets\\make_models.txt"));

                String[] nextline;
                while((nextline = reader.readNext()) != null) {
                    if(nextline != null) {
                    	insertIntoMakeModel(nextline[0], nextline[1], nextline[2], nextline[3]);
                    }
                }
    		}
            catch(Exception e) {
                System.out.println(e);
            }
        }
      
      void insertIntoCar(int car_ID, int sub_ID, String make, String model, String mileage, String consumption) {
          try { 
              String sql = "INSERT INTO car(car_ID, sub_ID, make, model, mileage, consumption) VALUES ('" +
                      car_ID + 
                      "', '" +
                      sub_ID +
                      "', '" +
                      make +
                      "', '" +
                      model +
                      "', '" +
                      mileage +
                      "', '" +
                      consumption +
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoCar\nmessage: " + e.getMessage());
          }
      }
      
      void importCar() {
			
  		try {
  			
            CSVReader reader = new CSVReader(new FileReader("C:\\Users\\f\\Dropbox\\CompSci\\DBS\\Milestones\\Datasets\\cars.txt"));
            ArrayList<String> make = new ArrayList<>(); ArrayList<String> model = new ArrayList<>(); 
            ArrayList<String> mileage = new ArrayList<>(); ArrayList<String> consumption = new ArrayList<>(); 

            String[] nextline;
            
            while((nextline = reader.readNext()) != null) {
                if(nextline != null) {
                make.add(nextline[0]); 
                model.add(nextline[1]);
                mileage.add(nextline[2]); 
                consumption.add(nextline[3]);
                }
            }
            ArrayList<Integer> IDs = selectSubIDs();
            for (int sub_ID : IDs) {
            	int ran = getRandomNumberInRange(100,200);
            	
            	for (int car_ID = 1; car_ID <= ran; car_ID++) {
            		int ran1 = getRandomNumberInRange(0,make.size());
            		insertIntoCar(car_ID, sub_ID, make.get(ran1), model.get(ran1), mileage.get(ran1), consumption.get(ran1));
            	}            		
            }        
  		}
        catch(Exception e) {
            System.out.println(e);
        }
    }
      
      void insertIntoFeature(String description) {
          try { 
              String sql = "INSERT INTO feature(description) VALUES ('" +
              		description + 
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoFeature\nmessage: " + e.getMessage());
          }
      }
      
      void importFeature() { 
  		
  		try {
  			
              CSVReader reader = new CSVReader(new FileReader("C:\\Users\\f\\Dropbox\\CompSci\\DBS\\Milestones\\Datasets\\car_features.txt"));

              String[] nextline;
              while((nextline = reader.readNext()) != null) {
                  if(nextline != null) {
                      insertIntoFeature(nextline[0]); 
                  }
              }
  		}
          catch(Exception e) {
              System.out.println(e);
          }
      }
      
      void insertIntoOrderPlaced(int e_ID) {
          try { 
              String sql = "INSERT INTO order_placed(e_ID) VALUES ('" +
                      e_ID + 
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoOrderPlaced\nmessage: " + e.getMessage());
          }
      }
      
      void importOrderPlaced() {
    	  	
    	  	try {
    	          ArrayList<Integer> IDs = selectEIDs();
    	  	        for(int in = 1; in <= 500; in++) { //500 Orders
    	  	            	int ran = getRandomNumberInRange(1,IDs.size());
    	  	            	insertIntoOrderPlaced(IDs.get(ran)); 
    	  	        }
    	  		}    	  	
    	  	catch(Exception e) {
  	          System.out.println(e);
    	  	}
      }
      
      void insertIntoCustomer(String licence_nr, String first_name, String last_name, String phone_nr, String gender) {
          try { 
              String sql = "INSERT INTO customer(licence_nr, first_name, last_name, phone_nr, gender) VALUES ('" +
              		licence_nr + 
                      "', '" +
                      first_name +
                      "', '" +
                      last_name +
                      "', '" +
                      phone_nr +
                      "', '" +
                      gender +
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoCustomer\nmessage: " + e.getMessage());
          }
      }

    	void importCustomer() { 

    		try {
    	
    			CSVReader reader = new CSVReader(new FileReader("C:\\Users\\f\\Dropbox\\CompSci\\DBS\\Milestones\\Datasets\\customers.txt"));

    			String[] nextline;
    			while((nextline = reader.readNext()) != null) {
    				if(nextline != null) {
    				insertIntoCustomer(nextline[0], nextline[1], nextline[2], nextline[3], nextline[4]);
    				}
    			}
    		}
    		catch(Exception e) {
        System.out.println(e);
    		}
    }
    	
    	void insertIntoHasBoss(int e_ID_1, int e_ID_2) {
            try { 
                String sql = "INSERT INTO hasBoss(e_ID_1, e_ID_2) VALUES ('" +
                		e_ID_1 + 
                        "', '" +
                        e_ID_2 +
                        "')";
                stmt.execute(sql);
            } catch (Exception e) {
                System.err.println("Error at: insertIntoHasBoss\nmessage: " + e.getMessage());
            }
        }
        
        void importHasBoss() {

    		try {	            	
    			ArrayList<Integer> IDs = selectEIDs();
	  	       	
    			for(int id1 = 0; id1 < IDs.size(); id1++) {
	  	            	int ran = getRandomNumberInRange(1,3);
	  	            	ArrayList<Integer> randomnrs1 = new ArrayList<>();
	  	            	for(int i = 1; i <= ran; i++) {
	  	            		int ran2 = getRandomNumberInRange(0,IDs.size());
	  	            		if ((IDs.get(id1) != IDs.get(ran2)) && (!randomnrs1.contains(ran2))) {
	  	            			insertIntoHasBoss(IDs.get(id1), IDs.get(ran2));
	  	            			randomnrs1.add(ran2);
	  	            		}
	  	            	}
	  	        }		           		
    		}
    		catch(Exception e) {
        System.out.println(e);
    		}
    	}
      
      void insertIntoHasFeature(int type_ID, int feature_ID) {
          try { 
              String sql = "INSERT INTO has_feature(type_ID, feature_ID) VALUES ('" +
              		type_ID + 
                      "', '" +
                      feature_ID +
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoHasFeature\nmessage: " + e.getMessage());
          }
      }
      
      void importHasFeature() { 

  		try {
			ArrayList<Integer> Type_IDs = selectTypeIDs();
			
			for(int id: Type_IDs) {
				insertIntoHasFeature(id, 1);
        		insertIntoHasFeature(id, 2);
        		
				if (id == 1) {
	            		insertIntoHasFeature(id, 3);
	            		insertIntoHasFeature(id, 6);
	            		insertIntoHasFeature(id, 10);
	            		insertIntoHasFeature(id, 13);
	            		insertIntoHasFeature(id, 18);
	            	}
				else if (id == 2) {
            		insertIntoHasFeature(id, 3);
            		insertIntoHasFeature(id, 5);
            		insertIntoHasFeature(id, 9);
            		insertIntoHasFeature(id, 13);
            		insertIntoHasFeature(id, 17);
            	}
				else if (id == 3) {
            		insertIntoHasFeature(id, 4);
            		insertIntoHasFeature(id, 6);
            		insertIntoHasFeature(id, 11);
            		insertIntoHasFeature(id, 14);
            		insertIntoHasFeature(id, 18);
            	}
				else if (id == 4) {
            		insertIntoHasFeature(id, 4);
            		insertIntoHasFeature(id, 7);
            		insertIntoHasFeature(id, 11);
            		insertIntoHasFeature(id, 15);
            		insertIntoHasFeature(id, 18);
            	}
				else if (id == 5) {
            		insertIntoHasFeature(id, 4);
            		insertIntoHasFeature(id, 8);
            		insertIntoHasFeature(id, 12);
            		insertIntoHasFeature(id, 16);
            		insertIntoHasFeature(id, 18);
            	}
				else if (id == 6) {
            		insertIntoHasFeature(id, 3);
            		insertIntoHasFeature(id, 5);
            		insertIntoHasFeature(id, 10);
            		insertIntoHasFeature(id, 14);
            		insertIntoHasFeature(id, 18);
            	}
				else if (id == 7) {
            		insertIntoHasFeature(id, 4);
            		insertIntoHasFeature(id, 7);
            		insertIntoHasFeature(id, 11);
            		insertIntoHasFeature(id, 15);
            		insertIntoHasFeature(id, 18);
            	}
			}
  		}
  		catch(Exception e) {
      System.out.println(e);
  		}
  	}
      
      void insertIntoRents(int order_ID, int car_ID, int sub_ID) {
          try { 
              String sql = "INSERT INTO rents(order_ID, car_ID, sub_ID) VALUES (" +
              		 order_ID + 
                      ", '" +
                      car_ID +
                      "', '" +
                      sub_ID +
                      "')";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoRents\nmessage: " + e.getMessage());
          }
      }
      
      void importRents() {

    	  try {
  			ArrayList<Integer> Car_IDs = selectCarIDsCars();
  			ArrayList<Integer> Sub_IDs = selectSubIDsCars();
  			ArrayList<Integer> Order_IDs = selectOrderIDs();
  			
  			for(int id1 = 0; id1 < Order_IDs.size(); id1++) {
  	            	int ran = getRandomNumberInRange(1,4);
  	            	ArrayList<Integer> randomnrs = new ArrayList<>();
  	            	for(int i = 1; i <= ran; i++) {
  	            		int ran1 = getRandomNumberInRange(0,Car_IDs.size());
  	            		if (!randomnrs.contains(ran1)) {
  	  	            		insertIntoRents(Order_IDs.get(id1), Car_IDs.get(ran1), Sub_IDs.get(ran1));
  	  	            		randomnrs.add(ran1);
  	            		}
  	            	}
  	            }	        
    		}
  		catch(Exception e) {
      System.out.println(e);
  		}
  	}
      
      void insertIntoOrderDeatils(int order_ID, int customer_ID, String start_d, String end_d) {
          try { 
              String sql = "INSERT INTO order_details(order_ID, customer_ID, start_d, end_d) VALUES (" +
              		 order_ID + 
                      ", '" +
                      customer_ID + 
                      "', TO_DATE('" +
                      start_d +
                      "', 'yyyy/mm/dd hh24:mi:ss'), TO_DATE('" +
                      end_d +
                      "', 'yyyy/mm/dd hh24:mi:ss'))";
              stmt.execute(sql);
          } catch (Exception e) {
              System.err.println("Error at: insertIntoOrderDeatils\nmessage: " + e.getMessage());
          }
      }
      
      void importOrderDetails() {

    	  try {
  			ArrayList<Integer> Order_IDs = selectOrderIDs();
  			ArrayList<Integer> Customer_IDs = selectCustomerIDs();
  			CSVReader reader = new CSVReader(new FileReader("C:\\Users\\f\\Dropbox\\CompSci\\DBS\\Milestones\\Datasets\\times.txt"));
  			
  			String[] nextline;
  			int counter = 0; int size = Order_IDs.size();
  			while((nextline = reader.readNext()) != null) {
  				if(nextline != null && counter < size) { // Avoids an error if there are unequal amount of orders and times
  					int cust = getRandomNumberInRange(0,Customer_IDs.size());
  					insertIntoOrderDeatils(Order_IDs.get(counter++), Customer_IDs.get(cust), nextline[0], nextline[1]);
  				}
  				}
  				        
    		}
  		catch(Exception e) {
      System.out.println(e);
  		}
  	}
    
    // ----------------------------------------------------//
    // -------------------------SELECTs--------------------//
    // ----------------------------------------------------//
    
  	
  	ArrayList<Integer> selectSubIDs() {
  		ArrayList<Integer> IDs = new ArrayList<>();
  		try {
            ResultSet rs = stmt.executeQuery("SELECT sub_ID FROM subsidiary");
            while (rs.next()) {
                IDs.add(rs.getInt("sub_ID"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectSubIDS\n message: " + e.getMessage()).trim());
        }
  		
  		return IDs;
  	}
  	
  	ArrayList<Integer> selectEIDs() {
  		ArrayList<Integer> IDs = new ArrayList<>();
  		try {
            ResultSet rs = stmt.executeQuery("SELECT e_ID FROM employee");
            while (rs.next()) {
                IDs.add(rs.getInt("e_ID"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectEIDS\n message: " + e.getMessage()).trim());
        }
  		
  		return IDs;
  	}
  	
  	ArrayList<Integer> selectCarIDsCars() {
  		ArrayList<Integer> IDs = new ArrayList<>();
  		try {
            ResultSet rs = stmt.executeQuery("SELECT car_ID FROM car order by car_ID, sub_ID ASC");
            while (rs.next()) {
                IDs.add(rs.getInt("car_ID"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectCarIDsCars\n message: " + e.getMessage()).trim());
        }	
  		return IDs;
  	}
  	
  	ArrayList<Integer> selectSubIDsCars() {
  		ArrayList<Integer> IDs = new ArrayList<>();
  		try {
            ResultSet rs = stmt.executeQuery("SELECT sub_ID FROM car order by car_ID, sub_ID ASC");
            while (rs.next()) {
                IDs.add(rs.getInt("sub_ID"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectSubIDsCars\n message: " + e.getMessage()).trim());
        }	
  		return IDs;
  	}
  	
  	ArrayList<Integer> selectOrderIDs() {
  		ArrayList<Integer> IDs = new ArrayList<>();
  		try {
            ResultSet rs = stmt.executeQuery("SELECT order_ID FROM order_placed");
            while (rs.next()) {
                IDs.add(rs.getInt("order_ID"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectOrderIDs\n message: " + e.getMessage()).trim());
        }	
  		return IDs;
  	}
  	
  	ArrayList<Integer> selectFeatureIDs() {
  		ArrayList<Integer> IDs = new ArrayList<>();
  		try {
            ResultSet rs = stmt.executeQuery("SELECT feature_ID FROM feature");
            while (rs.next()) {
                IDs.add(rs.getInt("feature_ID"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectFeatureIDs\n message: " + e.getMessage()).trim());
        }	
  		return IDs;
  	}
  	
  	ArrayList<Integer> selectCustomerIDs() {
  		ArrayList<Integer> IDs = new ArrayList<>();
  		try {
            ResultSet rs = stmt.executeQuery("SELECT customer_ID FROM customer");
            while (rs.next()) {
                IDs.add(rs.getInt("customer_ID"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectCustomerIDs\n message: " + e.getMessage()).trim());
        }	
  		return IDs;
  	}
  	
  	ArrayList<Integer> selectTypeIDs() {
  		ArrayList<Integer> IDs = new ArrayList<>();
  		try {
            ResultSet rs = stmt.executeQuery("SELECT type_ID FROM type");
            while (rs.next()) {
                IDs.add(rs.getInt("type_ID"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectTypeIDs\n message: " + e.getMessage()).trim());
        }	
  		return IDs;
  	}
  
    
 // ----------------------------------------------------//
    // -------------------------UPDATEs--------------------//
    // ----------------------------------------------------//

    void updateAll() {
        try { 
        	updateCustomer();
    		updateOrderPlaced();
    		updateEmployee();
    		updateSubsidiary();
        } catch (Exception e) {
            System.err.println("Error at: updateAll\nmessage: " + e.getMessage());
        }
    }
    
    void updateCustomer() {
        try { 
        	String sql = "UPDATE customer" + 
        	" SET (orders) = (" + 
        	" SELECT COUNT(*)" + 
        	" FROM order_details" + 
        	" NATURAL JOIN rents" + 
        	" WHERE customer.customer_ID = order_details.customer_ID)";
     
            stmt.execute(sql);
        } catch (Exception e) {
            System.err.println("Error at: updateCustomer\nmessage: " + e.getMessage());
        }
    }
    
    void updateOrderPlaced() {
        try { 
        	String sql = "UPDATE order_placed" + 
        			" SET (price) = (" + 
        			" WITH temp_result AS (SELECT *" + 
        			" FROM rents" + 
        			" Natural JOIN car" + 
        			" NATURAL JOIN make_model" + 
        			" NATURAL JOIN order_details)" +  
        			" SELECT ((trunc(end_d) - trunc(start_d)) * SUM(price_per_day))" + 
        			" FROM temp_result" + 
        			" WHERE order_placed.order_ID = temp_result.order_ID group by end_d, start_d)";
     
            stmt.execute(sql);
        } catch (Exception e) {
            System.err.println("Error at: updateOrderPlaced\nmessage: " + e.getMessage());
        }
    }
    
    void updateEmployee() {
        try { 
        	String sql = "UPDATE employee" + 
        			" SET (turnover) = (" + 
        			" SELECT SUM(price)" + 
        			" FROM order_placed" + 
        			" WHERE employee.e_ID = order_placed.e_ID)";
        	
            stmt.execute(sql);
        } catch (Exception e) {
            System.err.println("Error at: updateEmployee\nmessage: " + e.getMessage());
        }
    }
    
    void updateSubsidiary() {
        try { 
        	String sql = "UPDATE subsidiary" + 
        			" SET (employees) = (" + 
        			" SELECT COUNT(*)" + 
        			" FROM employee" + 
        			" WHERE subsidiary.sub_ID = employee.sub_ID)";
        	
            stmt.execute(sql);
            
            String sql1 = "UPDATE subsidiary" + 
        			" SET (cars_in_inventory) = (" + 
        			" SELECT COUNT(*)" + 
        			" FROM car" + 
        			" WHERE subsidiary.sub_ID = car.sub_ID)";
        	
            stmt.execute(sql1);
            
            String sql2 = "UPDATE subsidiary" + 
        			" SET (rented_cars_atm) = (" + 
        			" WITH temp_result AS (SELECT *" + 
        			" FROM rents" + 
        			" NATURAL JOIN order_details)" + 
        			" SELECT COUNT(*)" + 
        			" FROM temp_result" + 
        			" WHERE subsidiary.sub_ID = temp_result.sub_ID" + 
        			" AND ((SELECT CURRENT_DATE FROM DUAL) BETWEEN start_d AND end_d))";
        	
            stmt.execute(sql2);
            
            String sql3 = "UPDATE subsidiary" + 
        			" SET (turnover) = (" + 
        			" WITH temp_result AS (SELECT *" + 
        			" FROM order_placed" + 
        			" NATURAL JOIN rents)" + 
        			" SELECT SUM(price)" + 
        			" FROM temp_result" + 
        			" WHERE subsidiary.sub_ID = temp_result.sub_ID)";
            
            stmt.execute(sql3);
            
        } catch (Exception e) {
            System.err.println("Error at: updateSubsidiary\nmessage: " + e.getMessage());
        }
    }
          
    // -------------------Closing/Cleaning ------------------------
    
    public void close()  {
        try {
            stmt.close(); //clean up
            con.close();
        } catch (Exception ignored) {
        }
    }
}