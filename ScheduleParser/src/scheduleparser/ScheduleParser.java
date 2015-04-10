/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

package scheduleparser;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.jsoup.*;
import org.jsoup.nodes.*;
import org.jsoup.parser.*;
import org.jsoup.select.*;

/**
 *
 * @author mahefa
 */
public class ScheduleParser {
	Document doc;
	
	public ScheduleParser(String url) {
		doc = (Document) Jsoup.connect(url);
	}
	
	public static void main(String[] args) throws IOException {
		DB db = new DB();
//		getGroupList(db);
		for (GroupUrl gu : db.getGroupUrl()) {
			ArrayList<Para> paras = getPara(gu.group, gu.url);
			for (Para p : paras) {
//				p.insert(db);
				p.update(db);
			}
		}
		db.close();
	}
	
	public static void getGroupList(DB db) {
		try {
			String url = "http://www.bstu.ru/about/useful/schedule";
			Document doc = Jsoup.connect(url).get();
			String institute = null;
			Element all_schedule = doc.getElementsByTag("article").first();
//		int idFac = -1;
//		List<Groups> groups = new ArrayList<Groups>();
			for (Element e : all_schedule.children()) {
				if (e.tag().getName() == "h4") {
					institute = e.text();
//				idFac++;
					continue;
				}
				if (institute == null) continue;
				else {
					for (Element a : e.getElementsByTag("a")) {
						Groups g = new Groups(
							a.text(),
							institute,
							a.attr("href")
						);
						System.out.println(g);
//					groups.add(g);
//					g.setIdfac(idFac);
						g.insert(db);
//					db.executeQuery("INSERT INTO Faculty (name) VALUES (\"АСИ\")");
					}
				}
			}
		} catch (IOException ex) {
			Logger.getLogger(ScheduleParser.class.getName()).log(Level.SEVERE, null, ex);
		}
	}
	
	public static ArrayList<Para> getPara(String group, String urlSchedule) {
		ArrayList<Para> para = new ArrayList<>();
		try {
			Document doc = Jsoup.connect(urlSchedule).get();
			Element table = doc.getElementsByTag("table").first();
			int count = 0;
			System.out.println("Checking out group"+group+"; url: "+urlSchedule);
			for (Element p0 : table.getElementsByClass("schedule_std")) {
				int t = 0;
				for (Element p1 : p0.getElementsByClass("schedule_half")) {
					Elements p2 = p1.getElementsByTag("div");
					if (!p2.isEmpty()) {
						String subjectName = p1.getElementsByClass("subject_half").first().text();
						String profName = p1.getElementsByClass("sp_half").first().text().split(",")[0];
						String subFull = p1.getElementsByClass("subject_half").first().attr("title");
						Para p = new Para (
							group,
							subjectName,
							subFull,
							profName,
							count / 6 + 1,
							count % 6 + 1
						);
						p.setTypepara(t);
						para.add(p);
						System.out.println(p);
					}
					t++;
				}
				if (!p0.getElementsByClass("subject_std").isEmpty()) {
					String subjectName = p0.getElementsByClass("subject_std").first().text();
					String profName = p0.getElementsByClass("sp_std").first().text();
					String subFullName = p0.getElementsByClass("subject_std").first().attr("title");
					Para p = new Para (
						group,
						subjectName,
						subFullName,
						profName,
						count / 6 + 1,
						count % 6 + 1
					);
					p.setTypepara(2);
					para.add(p);
					System.out.println(p);
				}
				count++;
				if (count > 36) break;
			}
		} catch (IOException ex) {
			Logger.getLogger(ScheduleParser.class.getName()).log(Level.SEVERE, null, ex);
		}
		return para;
	}
}