package webscrape;

import java.io.IOException;
import java.util.List;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.select.Elements;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.Select;
import java.io.PrintWriter;
import java.awt.AWTException;
import java.io.File;
import java.io.FileWriter;
import org.openqa.selenium.chrome.ChromeDriver;

public class ACTScrape extends ScrapeCourseInfo {

    public ACTScrape() {

    }

    public void connect() throws IOException {
        driver.get("https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2017LE.html");
        loop();
    }

    List<WebElement> getTrTagList() {
        List<WebElement> trTagList = driver.findElements(By.tagName("tr"));
        return trTagList;
    }

    public String scrapeColumn(int index) {
        String print = "";
        List<WebElement> tags = getTrTagList().get(index).findElements(By.tagName("td"));
//        for(int i = 0; i < tags.size(); i++) {
//        	print += "  " + i + " " + tags.get(i).getText() + "  ";
//        }
        if (tags.size() == 4) { // this is for schedules/times of rooms, e.g. M 14:00 120 LAS C
        	/*
        	 * This block is the block that grabs the time regardless of whether its a lecture section or lab.
        	 * By the way, this has only been tested on the F/W 2017 Lassonde timetable.
        	 * TODO: Since CAT number is associated with tutorials (usually), some classes don't have labs/tutorials (EECS AI class) and therefore the CAT# is associated with the LECT section.
        	 * TODO: Add LECT CAT#.
        	 */
            print = tags.get(0).getText() + "  " + tags.get(1).getText()
                    + "  " + tags.get(2).getText()
                    + "  " + tags.get(3).getText();
		} else if (tags.size() == 13) { // LECTURE SECTIONS WITH ONLY ONE DAY, e.g. EECS 2030 LECT 01 M 12:00 90 LAS A
			print = tags.get(1).getText() + "  " + tags.get(2).getText() + "  " + tags.get(3).getText() + "  "
					+ tags.get(4).getText() + tags.get(11).getText();
        			
		} else if (tags.size() == 17) { // LECTURE SECTIONS WITH TWO DAYS, e.g. EECS 2031 LECT 01 M 12:00 90 LAS A W 12:00 90 LAS A
			print = tags.get(1).getText() + "  " + tags.get(2).getText() + "  " + tags.get(3).getText() + "  "
					+ tags.get(4).getText() + tags.get(15).getText();
			
        } else if (tags.size() == 21) { // LECTURE SECTIONS WITH THREE DAYS, e.g. you get the idea
        	print = tags.get(1).getText() + "  " + tags.get(2).getText() + "  " + tags.get(3).getText() + "  "
					+ tags.get(4).getText() + tags.get(19).getText();
        } else if (tags.size() == 9) { // CANCELLED SECTIONS, LOOK UP ENG 4002
        	print = tags.get(1).getText() + "  " + tags.get(2).getText() + "  " + tags.get(3).getText() + "  "
        			+ tags.get(4).getText() + "  " + tags.get(5).getText();
        } else if (tags.size() == 7) { // CANCELLED LABS/TUTORIALS, LOOK UP ENG 4002
        	print = tags.get(1).getText() + "  " + tags.get(2).getText() + "  " + tags.get(3);
        } else { // THIS IS FOR TUTORIALS
        	print = tags.get(1).getText() + "  " + tags.get(2).getText() + "  " + tags.get(3).getText() + "  " + tags.get(9).getText();
        }
        return print;
    }

//    public String scrapeColumn2(int index) {
//        List<WebElement> tags = getTrTagList().get(index).findElements(By.cssSelector("td[class='smallbodytext']"));
//        WebElement courseTimeTable = tags.get(4).findElement(By.cssSelector("table[width='100$']"));
//        String print = tags.get(0).getText() + "  " + tags.get(1).getText()
//                + "  " + tags.get(2).getText()
//                + "  " + tags.get(3).getText()
//                + " " + tags.get(4).getText();
//
//        return print;
//    }

    public void loop() {
        for (int i = 1; i < getTrTagList().size(); i++) {
            System.out.println(scrapeColumn(i));
        }
    }
}
