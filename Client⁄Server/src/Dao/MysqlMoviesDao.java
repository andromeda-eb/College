package Dao;

import Dto.Movie;
import Exception.DaoException;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import java.util.List;
import java.util.ArrayList;

import org.json.JSONObject;

import java.util.Scanner;

public class MysqlMoviesDao extends MysqlDao implements MovieDaoInterface{
	
	@SuppressWarnings("finally")
	public JSONObject search(String request, String searchType) throws DaoException {
		Connection con = null;
		PreparedStatement preparedStatement = null;
		ResultSet result = null;
		JSONObject movies = new JSONObject();
		
		String column = request.substring(7).split(" ")[0];
		String pattern = request.substring(7 + column.length() + 1);
		
		if(searchType.equals("LIKE"))
			pattern = '%' + pattern + '%';
		
		try {
			
			con = this.getConnection();
			String searchQuery = "SELECT * FROM movies WHERE " + column + " " + searchType + " ?";
			preparedStatement = con.prepareStatement(searchQuery);
			preparedStatement.setString(1, pattern);
			result = preparedStatement.executeQuery();
			 
			while(result.next()){
				
				String title = result.getString("title");
				JSONObject movieDetails = new JSONObject();
				
				movieDetails.put("Id", result.getInt("id"));
				movieDetails.put("Title", result.getString("title"));
				movieDetails.put("Genre", result.getString("genre"));
				movieDetails.put("Director", result.getString("director"));
				movieDetails.put("Runtime", result.getString("runtime"));
				movieDetails.put("Plot", result.getString("plot"));
				movieDetails.put("Location", result.getString("location"));
				movieDetails.put("Poster", result.getString("poster"));
				movieDetails.put("Rating", result.getString("rating"));
				movieDetails.put("Format", result.getString("format"));
				movieDetails.put("Year", result.getString("year"));
				movieDetails.put("Starring", result.getString("starring"));
				movieDetails.put("Copies", result.getInt("copies"));
				movieDetails.put("Barcode", result.getString("barcode"));
				movieDetails.put("User Rating", result.getDouble("user_rating"));
				
				movies.put(title, movieDetails).toString(5);
			}
				
			con.close(); 
			
		}catch(SQLException e) {
			throw new DaoException("search() " + e.getMessage());
		}finally {
			try {
				if (result != null)
					result.close();
				if (preparedStatement != null)
					preparedStatement.close();
				if (con != null)
					freeConnection(con);
			}catch(SQLException e) {
				throw new DaoException("search() " + e.getMessage());
			}
			return movies;
		}
	}
	
	public String stringInput(String column) {
		Scanner string = new Scanner(System.in);
		System.out.print("\nEnter (String) " + column + ": ");
		return string.nextLine();
	}
	
	public int intInput(String column) {
		Scanner integers = new Scanner(System.in);
		System.out.print("\nEnter (int) " + column + ": ");
		return integers.nextInt();
	}
	
	public double doubleInput(String column) {
		Scanner doubles = new Scanner (System.in);
		System.out.print("\nEnter (double) " + column + ": ");
		return doubles.nextDouble();
	} 
	
	public JSONObject add() throws DaoException {
		Connection con = null;
		PreparedStatement preparedStatement = null;
		String Columns = "(title, genre, director, runtime, plot, location, poster, rating, format, year, starring, copies, barcode, user_rating)";
		String replacementParameters = "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		try {
			con = this.getConnection();
			String addQuery = "INSERT INTO movies " + Columns + " VALUES " + replacementParameters;
			preparedStatement = con.prepareStatement(addQuery);
			String title = stringInput("title");
			preparedStatement.setString(1, title);
			preparedStatement.setString(2, stringInput("genre"));
			preparedStatement.setString(3, stringInput("director"));
			preparedStatement.setString(4, stringInput("runtime"));
			preparedStatement.setString(5, stringInput("plot"));
			preparedStatement.setString(6, stringInput("location"));
			preparedStatement.setString(7, stringInput("poster"));
			preparedStatement.setString(8, stringInput("rating"));
			preparedStatement.setString(9, stringInput("format"));
			preparedStatement.setString(10, stringInput("year"));
			preparedStatement.setString(11, stringInput("starring cast"));
			preparedStatement.setInt(12, intInput("copies"));
			preparedStatement.setString(13, stringInput("barcode"));
			preparedStatement.setDouble(14, doubleInput("user rating"));
			preparedStatement.execute();
			con.close();
			
			return search("search title " + title, "=");
			
		}catch(SQLException e) {
			throw new DaoException("addMovie() " + e.getMessage());
		}finally {
			try {
				if(preparedStatement != null)
					preparedStatement.close();
				if(con != null)
					freeConnection(con);
			}catch(SQLException e) {
				throw new DaoException("addMovie() " + e.getMessage());
			}
		}
	}
	
	public String remove(String request) throws DaoException{
		Connection con = null;
		PreparedStatement preparedStatement = null;
		
		String[] arr = request.substring(7).split(" ");
		String column = arr[0];
		
		try {
			con = this.getConnection();
			String removeQuery = "DELETE FROM movies WHERE " + column + " = ?";
			preparedStatement = con.prepareStatement(removeQuery);
			
			if(column.equals("id"))
				preparedStatement.setInt(1, Integer.parseInt( arr[1] ));
			else
				preparedStatement.setString(1,  arr[1] );
			
			preparedStatement.execute();
			con.close();
			
			return column + " " + arr[1] + " has been removed"; 
			
		}catch(SQLException e) {
			throw new DaoException("removeMovie() " + e.getMessage());
		}finally {
			try {
				if(preparedStatement != null)
					preparedStatement.close();
				if(con != null)
					freeConnection(con);
			}catch(SQLException e) {
				throw new DaoException("removeMovie() " + e.getMessage());
			}
		}
	}
	
	public String update(String request) throws DaoException{
		Connection con = null;
		PreparedStatement preparedStatement = null;
		JSONObject o;
		
		String[] arr = request.substring(7).split(" ");
		String column = arr[0];
		int id = Integer.parseInt(arr[arr.length-1]); // stores id required for update
		String columnValue = stringInput(column); // assigns the updated value for query
		
		try {
			con = this.getConnection();
			String updateQuery = "UPDATE movies SET " + column + " = ? WHERE id = ?";
			preparedStatement = con.prepareStatement(updateQuery);
			preparedStatement.setString(1,  columnValue);
			preparedStatement.setInt(2,  id);
			preparedStatement.execute();
			con.close();
			
			return column + " of movie id " + id + " has been updated to " + columnValue;
		}catch(SQLException e) {
			throw new DaoException("updateMovie() " + e.getMessage());
		}finally {
			try {
				if(preparedStatement != null)
					preparedStatement.close();
				if(con != null)
					freeConnection(con);
			}catch(SQLException e) {
				throw new DaoException("updateMovie() " + e.getMessage());
			}
		}
	} 
	
	@SuppressWarnings("finally")
	public JSONObject recommend(String request) throws DaoException{
		Connection con = null;
		PreparedStatement preparedStatement = null;
		ResultSet result = null;
		JSONObject movies = new JSONObject();
		
		String[] arr = request.substring(10).split(" ");
		
		String column = arr[0];
		String pattern = '%' + arr[1] + '%';
		
		try {
			con = this.getConnection();
			String recommendQuery = "SELECT * FROM movies WHERE " + column + " LIKE ?";
			preparedStatement = con.prepareStatement(recommendQuery);
			preparedStatement.setString(1,  pattern);
			result = preparedStatement.executeQuery();

			while(result.next()){
				
				String title = result.getString("title");
				JSONObject movieDetails = new JSONObject();
				
				movieDetails.put("Id", result.getInt("id"));
				movieDetails.put("Title", result.getString("title"));
				movieDetails.put("Genre", result.getString("genre"));
				movieDetails.put("Director", result.getString("director"));
				movieDetails.put("Runtime", result.getString("runtime"));
				movieDetails.put("Plot", result.getString("plot"));
				movieDetails.put("Location", result.getString("location"));
				movieDetails.put("Poster", result.getString("poster"));
				movieDetails.put("Rating", result.getString("rating"));
				movieDetails.put("Format", result.getString("format"));
				movieDetails.put("Year", result.getString("year"));
				movieDetails.put("Starring", result.getString("starring"));
				movieDetails.put("Copies", result.getInt("copies"));
				movieDetails.put("Barcode", result.getString("barcode"));
				movieDetails.put("User Rating", result.getDouble("user_rating"));
				
				movies.put(title, movieDetails).toString(5);
			}
			
			con.close();
			
		}catch(SQLException e) {
			throw new DaoException("updateMovie() " + e.getMessage());
		}finally {
			try {
				if(preparedStatement != null)
					preparedStatement.close();
				if(con != null)
					freeConnection(con);
			}catch(SQLException e) {
				throw new DaoException("updateMovie() " + e.getMessage());
			}
			return movies;
		}
	} 
	
	@SuppressWarnings("finally")
	public String watch(String request) throws DaoException{
		Connection con = null;
		PreparedStatement preparedStatement = null;
		ResultSet result = null;
		JSONObject foundMovie = new JSONObject();
		
		String pattern = request.substring(6);
 
		if( search("search title " + pattern, "=").length() != 0 )
			return pattern;
		else
			return "Title doesn't exist in the database";
	
	} 

}
