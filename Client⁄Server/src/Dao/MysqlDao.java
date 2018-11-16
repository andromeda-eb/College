package Dao;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import Exception.DaoException;

public class MysqlDao {
	
	public Connection getConnection() throws DaoException{
		final String DRIVER = "com.mysql.jdbc.Driver";
		final String URL = "jdbc:mysql://localhost:3306/movies";
		final String USERNAME = "root";
		final String PASSWORD = "";
		Connection con = null;
		
		try {
			Class.forName(DRIVER);
			con = DriverManager.getConnection(URL, USERNAME, PASSWORD);
		}catch(ClassNotFoundException ex1) {
			System.out.println("Failed to find driver class " + ex1.getMessage());
			System.exit(1);
		}catch(SQLException ex2) {
			System.out.println("Connection failed " + ex2.getMessage());
		}
		return con;
	}
	
	public void freeConnection(Connection con) throws DaoException{
		try {
			if(con != null) {
				con.close();
				con = null;
			}
		}catch(SQLException e) {
			System.out.println("Failed to free connection " + e.getMessage());
			System.exit(1);
		}
	}
}
