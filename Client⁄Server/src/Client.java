import java.io.*;
import java.net.*;

public class Client {
	public static void main(String args[]) throws IOException{
		final String HOST = "localhost";
		final int PORT = 5678;
		
		System.out.println("Client -> Server: Trying to establish a connection");
		
		try(
				
			Socket clientSocket = new Socket(HOST, PORT);
			PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
			BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
				
			){
			
			String serverData;
			BufferedReader input = new BufferedReader( new InputStreamReader(System.in) );
			String request;
			
			/*
			 * search title/director x
			 * add
			 * remove id/title x
			 * update title/director id x
			 * recommend genre/director x
			 * */

			while( (serverData = in.readLine()) != null ) {
				
				while( in.ready() ) 
					serverData += in.readLine() + '\n';
				
				System.out.println('\n' + serverData);
				
				System.out.print("\nEnter request: ");
				request = input.readLine();
				out.println(request);
				serverData = "";
			}
			
		}catch(UnknownHostException e) {
			System.err.println("Host " + HOST + " is not recognized");
			System.exit(1);
		}catch(IOException e) {
			System.err.println("Couldn't get the IO for host connection");
			System.exit(1);
		}
	}
}
