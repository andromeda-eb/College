package Dto;

public class Movie {
	private int id;
	private String title;
	private String genre;
	private String director;
	private String runTime;
	private String plot;
	private String location;
	private String poster;
	private String rating;
	private String format;
	private String year;
	private String starring;
	private int copies;
	private String barcode;
	private double userRating;
	
	public Movie() {
		
	}
	// constructor for sending movie object to database ( without id field )
	public Movie(String title, String genre, String director, String runTime, String plot, String location, String poster, String rating,
			 String format, String year, String starring, int copies, String barcode, double userRating) {
	this.title = title;
	this.genre = genre;
	this.director = director;
	this.runTime = runTime;
	this.plot = plot;
	this.location = location;
	this.poster = poster;
	this.format = format;
	this.year = year;
	this.starring = starring;
	this.copies = copies;
	this.barcode = barcode;
	this.userRating = userRating;
}
	// constructor for recieving movie object from database ( with id field ) 
	public Movie(int id, String title, String genre, String director, String runTime, String plot, String location, String poster, String rating,
				 String format, String year, String starring, int copies, String barcode, double userRating) {
		this(title, genre, director, runTime, plot, location, poster, rating, format, year, starring, copies, barcode, userRating);
		this.id = id;
	}
	
	
	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public String getTitle() {
		return title;
	}
	public void setTitle(String title) {
		this.title = title;
	}
	public String getGenre() {
		return genre;
	}
	public void setGenre(String genre) {
		this.genre = genre;
	}
	public String getDirector() {
		return director;
	}
	public void setDirector(String director) {
		this.director = director;
	}
	public String getRuntime() {
		return runTime;
	}
	public void setRuntime(String runtime) {
		this.runTime = runtime;
	}
	public String getPlot() {
		return plot;
	}
	public void setPlot(String plot) {
		String[] sentences = plot.split(" ");
		
		for(String sentence: sentences)
			this.plot += sentence + "\n";
		//this.plot = plot;
	}
	public String getLocation() {
		return location;
	}
	public void setLocation(String location) {
		this.location = location;
	}
	public String getPoster() {
		return poster;
	}
	public void setPoster(String poster) {
		this.poster = poster;
	}
	public String getRating() {
		return rating;
	}
	public void setRating(String rating) {
		this.rating = rating;
	}
	public String getFormat() {
		return format;
	}
	public void setFormat(String format) {
		this.format = format;
	}
	public String getYear() {
		return year;
	}
	public void setYear(String year) {
		this.year = year;
	}
	public String getStarring() {
		return starring;
	}
	public void setStarring(String starring) {
		this.starring = starring;
	}
	public int getCopies() {
		return copies;
	}
	public void setCopies(int copies) {
		this.copies = copies;
	}
	public String getBarcode() {
		return barcode;
	}
	public void setBarcode(String barcode) {
		this.barcode = barcode;
	}
	public double getUserRating() {
		return userRating;
	}
	public void setUserRating(double userRating) {
		this.userRating = userRating;
	}
	
	public String toString() {
		return "\nID: " + id + "\nTitle: " + title + "\nGenre: " + genre + "\nDirector: " + director + "\nRuntime: " + runTime + "\nPlot: " +
			   plot + "\nLocation: " + location + "\nPoster: " + poster + "\nRating: " + rating + "\nFormat: " + format + "\nYear: " +
			   year + "\nStarring: " + starring + "\nCopies: " + copies + "\nBarcode: " + barcode + "\nUser Rating: " + userRating + "\n";
	}
}
