import java.net.*;
import Dao.MysqlMoviesDao;
import Exception.DaoException;
import Dao.MovieDaoInterface;
import org.json.JSONException;
import org.json.JSONObject;

import Dto.Movie;
import java.io.*;
import java.util.Arrays;
import java.util.Map;
import java.util.Set;
import java.util.TreeMap;
import java.util.TreeSet;

public class Server { 
	public static void main(String args[]) throws IOException, DaoException, JSONException{
		final int PORT = 5678;
		MovieDaoInterface m = new MysqlMoviesDao();
		
		System.out.println("Server <- Client: Waiting for the client to connect");
		
		try(
			ServerSocket serverSocket = new ServerSocket(PORT);
			Socket clientSocket = serverSocket.accept();
			PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true); 
			BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
			){
			
			String successMessage = "Client <- Server: Connection with the server has been established\n";
			out.println(successMessage);
			 
			String request; // client request
			
			Map<String, String> searchedMovies = new TreeMap<>(); // object for previoulsy searched movvies
			
			JSONObject watchedMovies = new JSONObject(); // object for watched movies
			watchedMovies.put("Watched Movies", new TreeSet<String>());
			
			while( (request = in.readLine()) != null ) {
				
				String[] requestArr = request.split(" "); // splits request with delimiter space
				
				switch(requestArr[0]) { // evaluates the command/first word
					case "search": 		
						
						if(searchedMovies.get(request) != null)
							out.println("Search exists in the local database (no need to connect to localhost) \n\n" + searchedMovies.get(request)); // if search has been previously done it will get the results from the map
						else if(  requestArr.length > 2 && (requestArr[1].equals("title") || requestArr[1].equals("director")) ) { // if search has not been done before it will store it in map then fetch results from map
							searchedMovies.put(request, m.search( request, "LIKE" ).toString(5) ); // if request hasn't been done before then it stores it in map 
							out.println(searchedMovies.get(request).toString()); // send results stored in map to client
						}
						else
							out.println("Invalid search request");
						
						break;
					case "add":
						out.println("\nAdded to the database\n" + m.add().toString(5));
						break;
					case "remove":
						
						if( requestArr.length > 2 && (requestArr[1].equals("id") || requestArr[1].equals("title")) ) // can remove by either id or title e.g remove title iron man
							out.println(m.remove(request));
						else
							out.println("Invalid remove request");
						
						break;
					case "update":
						//update either title/director by id
						if( requestArr.length > 4 && (requestArr[1].equals("title") || requestArr[1].equals("director")) && requestArr[3].equals("id")) 
							out.println(m.update(request));
						else
							out.println("Invalid update request");
						
						break;
					case "recommend":
						
						if(requestArr.length > 2  && (requestArr[1].equals("genre") || requestArr[1].equals("director")))
							out.println(m.recommend(request).toString(5));
						else
							out.println("Invalid recommend request");
						break;
					case "watch":
						
						if(requestArr.length > 1) {
							
							String result = m.watch(request);
							
							if(result.equals("Title doesn't exist in the database"))
								out.println("Title doesn't exist in the database");
							else {
								String movieList = "".join(",", watchedMovies.get("Watched Movies").toString().replaceAll("\\[", "").replaceAll("\\]", "").replaceAll("\"", ""));
								movieList += "," + result;
								String[] arr = movieList.split(",");
								watchedMovies.put("Watched Movies", new TreeSet(Arrays.asList(arr)));
								out.println(watchedMovies.toString(5));
							}
						}
						else
							out.println("Invalid watch request");
						
						break;
					default:
						out.println("Invalid request");
						break;
				}
	 
			}

		}catch(IOException e) {
			System.out.println("Exception when trying to listen on port/ listen for connection");
			System.out.println(e.getMessage());
		}
	}
}
