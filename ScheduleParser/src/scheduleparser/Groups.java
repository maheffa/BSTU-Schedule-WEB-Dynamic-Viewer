/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

package scheduleparser;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author mahefa
 */
class GroupUrl {
	public String group, url;

	public GroupUrl(String group, String url) {
		this.group = group;
		this.url = url;
	}
}

public class Groups {
	private String name, institute, url;
	private int year, idfac;
	private String insFac = "INSERT IGNORE INTO Faculty (name) VALUES (?)";
	private String insGrp = "INSERT IGNORE INTO GroupUni (name, year, faculty, url)"
		+ " VALUES (?, ?, ?, ?)";
	private String selFac = "SELECT idFaculty FROM Faculty WHERE name = ?";
	
	public Groups(String name, String institute, String url) {
		this.name = name;
		this.institute = institute;
		this.url = url; 
		String[] t = name.split("-");
		if (t.length >= 2)
			year = t[1].charAt(0) - '0';
	}
	
	public String getUrl() {
		return url;
	}
	
	public String getName() {
		return name;
	}
	
	public String getInstitute() {
		return institute;
	}
	
	public int getYear() {
		return year;
	}

	public int getIdfac() {
		return idfac;
	}

	public void setIdfac(int idfac) {
		this.idfac = idfac;
	}
	
	public void insert(DB db) {
		try {
			PreparedStatement ps = db.prepare(this.insFac);
			ps.setString(1, this.getInstitute());
			db.executeUpdate(ps);
			int id = db.getId("Faculty", "idFaculty", "name", this.getInstitute());
			ps = db.prepare(this.insGrp);
			ps.setString(1, this.getName());
			ps.setInt(2, this.year);
			ps.setInt(3, id); 
			ps.setString(4, this.url);
			db.executeUpdate(ps);
		} catch (SQLException ex) {
			Logger.getLogger(Groups.class.getName()).log(Level.SEVERE, null, ex);
		}
	}

	@Override
	public String toString() {
		return "Groups{" + "name=" + name + ", institute=" + institute + ", url=" + url + ", year=" + year + ", insFac=" + insFac + ", insGrp=" + insGrp + ", selFac=" + selFac + '}';
	}
	
}
