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
        if (tags.size() == 4) {
            print = tags.get(0).getText() + "  " + tags.get(1).getText()
                    + "  " + tags.get(2).getText()
                    + "  " + tags.get(3).getText();
        } else {
            print = tags.get(0).getText() + "  " + tags.get(1).getText()
                    + "  " + tags.get(2).getText()
                    + "  " + tags.get(3).getText()
                    + "  " + tags.get(4).getText();
        }
        return print;
    }

    public String scrapeColumn2(int index) {
        List<WebElement> tags = getTrTagList().get(index).findElements(By.cssSelector("td[class='smallbodytext']"));
//        WebElement courseTimeTable = tags.get(4).findElement(By.cssSelector("table[width='100$']"));
        String print = tags.get(0).getText() + "  " + tags.get(1).getText()
                + "  " + tags.get(2).getText()
                + "  " + tags.get(3).getText()
                + " " + tags.get(4).getText();

        return print;
    }

    public void loop() {
        for (int i = 1; i < getTrTagList().size(); i++) {
            System.out.println(scrapeColumn(i));
        }
    }
}
