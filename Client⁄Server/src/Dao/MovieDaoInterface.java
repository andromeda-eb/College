package Dao;

import Exception.DaoException;
import Dto.Movie;
import org.json.JSONObject;

public interface MovieDaoInterface {
	public JSONObject search(String request, String searchType) throws DaoException;
	public JSONObject add() throws DaoException;
	public String remove(String request) throws DaoException;
	public String update(String request) throws DaoException;
	public JSONObject recommend(String request) throws DaoException;
	public String watch(String request) throws DaoException;
}
