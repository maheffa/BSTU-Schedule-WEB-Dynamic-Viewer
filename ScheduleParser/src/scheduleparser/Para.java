/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package scheduleparser;

import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author mahefa
 */
public class Para {
	private String group, subject, sub_full_name, prof;
	private int para, day, typepara;

	private String insSub = "INSERT IGNORE INTO Subject (name, full_name) VALUES (?, ?)";
	private String insProf = "INSERT IGNORE INTO Prof (name) VALUES (?)";
	private String insSched = "INSERT IGNORE INTO Schedule (para, day, prof,"
		+ " subject, groupUni) VALUES (?,?,?,?,?)";

	public Para(String group, String subject, String sub_full_name, String prof, int para, int day) {
		this.group = group;
		this.subject = subject;
		this.sub_full_name = sub_full_name;
		this.prof = prof.split(",")[0];
		this.para = para;
		this.day = day;
	}


	public int getTypepara() {
		return typepara;
	}

	public void setTypepara(int typepara) {
		this.typepara = typepara;
	}	
	
	public String getGroup() {
		return group;
	}

	public String getSubject() {
		return subject;
	}

	public String getSub_full_name() {
		return sub_full_name;
	}

	public String getProf() {
		return prof;
	}

	public int getPara() {
		return para;
	}

	public int getDay() {
		return day;
	}

	public void insert(DB db) {
		try {
			PreparedStatement ps = db.prepare(this.insProf);
			ps.setString(1, this.getProf());
			db.executeUpdate(ps);
			ps = db.prepare(this.insSub);
			ps.setString(1, this.getSubject());
			ps.setString(2, this.getSub_full_name());
			db.executeUpdate(ps);
			int idProf = db.getId("Prof", "idProf", "name", this.getProf());
			int idSub = db.getId("Subject", "idSubject", "name", this.getSubject());
			int idGrp = db.getId("GroupUni", "idGroup", "name", this.getGroup());
			if (idProf < 0 || idSub < 0 || idGrp < 0) {
				System.err.println("ID NEGATIVE ... aborting");
				return;
			}
			ps = db.prepare(this.insSched);
			ps.setInt(1, this.getPara());
			ps.setInt(2, this.getDay());
			ps.setInt(3, idProf);
			ps.setInt(4, idSub);
			ps.setInt(5, idGrp);
			db.executeUpdate(ps);

		} catch (SQLException ex) {
			Logger.getLogger(Para.class.getName()).log(Level.SEVERE, null, ex);
		}
	}

	public void update(DB db) {
		try {
			String up = "update Schedule set typepara = ? where day"
				+ " = ? and prof = ? and subject = ? and groupUni"
				+ " = ? and para = ?";
			PreparedStatement ps = db.prepare(up);
			int idProf = db.getId("Prof", "idProf", "name", this.getProf());
			int idSub = db.getId("Subject", "idSubject", "name", this.getSubject());
			int idGrp = db.getId("GroupUni", "idGroup", "name", this.getGroup());
			if (idProf < 0 || idSub < 0 || idGrp < 0) {
				System.err.println("ID NEGATIVE ... aborting");
				return;
			}
			ps.setInt(1, this.getTypepara());
			ps.setInt(2, this.getDay());
			ps.setInt(3, idProf);
			ps.setInt(4, idSub);
			ps.setInt(5, idGrp);
			ps.setInt(6, this.getPara());
			db.executeUpdate(ps);

		} catch (SQLException ex) {
			Logger.getLogger(Para.class.getName()).log(Level.SEVERE, null, ex);
		}
	}

	@Override
	public String toString() {
		return "Para{" + "group=" + group + ", subject=" + subject + ", sub_full_name=" + sub_full_name + ", prof=" + prof + ", para=" + para + ", day=" + day + '}';
	}

	
}
