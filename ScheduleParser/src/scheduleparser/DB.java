/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

package scheduleparser;

import java.sql.*;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author mahefa
 */
public class DB {
	static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";
	static final String DB_URL = "jdbc:mysql://localhost/ScheduleUniv?useUnicode=true&characterEncoding=UTF-8";
	static final String USER = "root";
	static final String PASS = "t00r";
	Statement stmt = null;
	Connection conn = null;
	
	public DB() {
		try{
			Class.forName("com.mysql.jdbc.Driver");
			conn = DriverManager.getConnection(DB_URL,USER,PASS);
		} catch(Exception e){
			e.printStackTrace();
		}
	}
	
	public void close() {
		try {
			conn.close();
		} catch (SQLException ex) {
			Logger.getLogger(DB.class.getName()).log(Level.SEVERE, null, ex);
		}
	}
	
	public PreparedStatement prepare(String query) {
		try {
			return conn.prepareStatement(query);
		} catch (SQLException ex) {
			Logger.getLogger(DB.class.getName()).log(Level.SEVERE, null, ex);
		}
		return null;
	}
	
	public void executeUpdate(PreparedStatement ps) {
		try {
//			System.out.println("UPDATING: "+ps.toString());
			ps.executeUpdate();
//			ps.close();
		} catch (SQLException ex) {
			Logger.getLogger(DB.class.getName()).log(Level.SEVERE, null, ex);
		}
	}
	
	public ResultSet executeQuery(PreparedStatement ps) {
		try {
			ResultSet rs = ps.executeQuery();
//			ps.close();
			return rs;
			
		} catch (SQLException ex) {
			Logger.getLogger(DB.class.getName()).log(Level.SEVERE, null, ex);
		}
		return null;
	}
	
	public int getId(String table, String id, String col, String val) {
		try {
			String q = "SELECT "+id+" FROM "+table+" WHERE "+col+" = \""+val+"\" LIMIT 1";
//			System.out.println("QUERY: "+q);
			ResultSet rs = conn.createStatement().executeQuery(q);
			if (rs.next())
				return rs.getInt(id);
		} catch (SQLException ex) {
			Logger.getLogger(DB.class.getName()).log(Level.SEVERE, null, ex);
		}
		return -1;
	}
	
	public ArrayList<GroupUrl> getGroupUrl() {
		ArrayList<GroupUrl> res = new ArrayList<>();
		try {
			String q = "SELECT name, url from GroupUni";
			ResultSet rs = conn.createStatement().executeQuery(q);
			while (rs.next()) {
				res.add(new GroupUrl(rs.getString("name"), rs.getString("url")));
			}
		} catch (SQLException ex) {
			Logger.getLogger(DB.class.getName()).log(Level.SEVERE, null, ex);
		}
		return res;
	} 
//	public void executeUpdate(String query) {
//		System.out.println("UPDATING: "+query);
//		Statement st = null;
//		try {
//			st = conn.createStatement();
//			st.executeQuery(query);
//			st.close();
//		} catch (SQLException ex) {
//			Logger.getLogger(DB.class.getName()).log(Level.SEVERE, null, ex);
//		} finally {
//			try {
//				if(st != null) {
//					st.close();
//				}
//			} catch (SQLException se) {
//				se.printStackTrace();
//			}
//		}
//	}
//
//	public ResultSet executeQuery(String query) {
//		System.out.println("QUERY: "+query);
//		Statement st = null;
//		ResultSet rs = null;
//		try {
//			st = conn.createStatement();
//			rs = st.executeQuery(query);
//			st.close();
//		} catch (SQLException ex) {
//			Logger.getLogger(DB.class.getName()).log(Level.SEVERE, null, ex);
//		} finally {
//			try {
//				if(st != null) {
//					st.close();
//				}
//			} catch (SQLException se) {
//				se.printStackTrace();
//			}
//		}
//
//		return rs;
//	}
}