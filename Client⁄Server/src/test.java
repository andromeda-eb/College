import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashSet;
import java.util.List;
import java.util.Scanner;

public class test {
	public static void main(String args[]) throws JSONException {
	JSONObject j = new JSONObject();
	j.put("watched movies", new HashSet<>(Arrays.asList("a","b")));
	System.out.println(j.toString(5));
	
	String test= "".join(",", j.get("watched movies").toString().replaceAll("\\[", "").replaceAll("\\]", "").replaceAll("\"", ""));
	
	
	 
	String l = ",my left foot";
	
	String[] arr = (test + l).split(",");
	for(String x: arr)
		System.out.println(x);
	
	j.put("watched movies", new HashSet(Arrays.asList(arr)));
	
	System.out.println(j.toString(4));
	}
}
