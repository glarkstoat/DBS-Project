package dbs_tut;

import java.io.*; 

public class Tester {

	public static void main(String[] args) throws IOException {
		DatabaseHelper dbHelper=new DatabaseHelper();
			
		dbHelper.importAll(); 
		
		dbHelper.close();	
}
}
