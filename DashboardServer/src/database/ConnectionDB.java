package database;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

/**
 * 
 * @author Paco
 *
 */
public class ConnectionDB {

	private String password = "";
	private String dbname = "";
	private String user = "";
	
	/**
	 * 
	 * @param password
	 * @param dbname
	 * @param user
	 */
	public ConnectionDB(String password, String dbname, String user) {
		this.password = password;
		this.dbname = dbname;
		this.user = user;
	}



	/**
	 * Connect to the database
	 * @return
	 * @throws ClassNotFoundException 
	 * @throws SQLException 
	 */
	public Connection connection() throws ClassNotFoundException, SQLException{
		Class.forName("com.mysql.jdbc.Driver");
		System.out.println("Driver OK");
		String url = "jdbc:mysql://localhost:3306/"+dbname;
		Connection conn = DriverManager.getConnection(url, user, password);
		System.out.println("Connexion OK");
		return conn;
	}

}//end of class
