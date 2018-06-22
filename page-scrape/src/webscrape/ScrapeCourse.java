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

public class ScrapeCourse extends ScrapeCourseInfo {

    public void connectionOne() throws IOException, AWTException {

        Document doc = Jsoup.connect("https://w2prod.sis.yorku.ca/Apps/WebObjects/cdm").userAgent("Mozilla").get();
        Elements result = doc.select("ul.bodytext");
        Elements result2 = result.select("a[href]");
        absHref = result2.attr("abs:href");
        this.setabsHref(absHref);
        this.connectionTwo();
    }

    public void connectionTwo() throws IOException, AWTException {

        driver.get(this.getHref());
        select = driver.findElement(By.name("sessionPopUp"));
        sessionSelect = new Select(select);
        sessionSelect.selectByVisibleText(session); // selects the 'given session (Fall/Winter or Summer)' option

        select2 = driver.findElement(By.name("subjectPopUp"));
        List<WebElement> option = select2.findElements(By.tagName("option"));
        courseSelect = new Select(select2);

//        printWriter = new PrintWriter(new FileWriter(fileLocation));

        submitCourse = driver.findElement(By.name("3.10.7.5"));

        // loop that clicks through all the course subjects in the list
        for (int i = 0; i < option.size(); i++) {
            select2 = driver.findElement(By.name("subjectPopUp"));
            List<WebElement> options = select2.findElements(By.tagName("option"));

            System.out.println(i + 1 + ")" + " --> " + options.get(i).getText());
//            printWriter.println(options.get(i).getText());

            for (int k = i; k < i + 1; k++) {
                String j = Integer.toString(k);
                keepTrack = k;
                this.setKeepTrack(keepTrack);

                select2 = driver.findElement(By.name("subjectPopUp"));
                courseSelect = new Select(select2);
                courseSelect.selectByValue(j);

                submitCourse = driver.findElement(By.name("3.10.7.5")); // finds html name of submit button on course page
                submitCourse.click();

                System.out.println("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
//                printWriter.println("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
                this.scrapeCourses();
            }
            this.returnToSubject();
        }
    }

    public void scrapeCourses() throws IOException {
        List<WebElement> courseCode = getCourseCodeElement();

        if (courseCode.isEmpty()) {
            System.out.println("----------NO COURSES FOUND----------");
        } else {
            for (int i = 0; i < courseCode.size(); i++) {

                String[] result = new String[courseCode.size()];
                result[i] = printCourseCode(i) + " - " + printCourseTitle(i);
                System.out.println(result[i]);
//                printWriter.println(result[i]);

                if (i == 0) {
                    clickOnCourseScheduleLink(i);
                } else {
                    clickOnCourseScheduleLink(i + i);
                }

                System.out.println("[" + getCourseDescription() + "]");
                keepTrack2 = i;
                keepTrack2++;
                driver.navigate().back();
                driver.navigate().refresh();
                if (driver.findElements(By.cssSelector("td[width='16%']")).isEmpty()) {
                    System.out.println("Page timed out"); // message to let me know if page has timed out
                    this.pageTimeOutFix();
                    break;
                }
            }
        }
    }
    
    /*
    Janky method to restart the loop should the web page crash
    */
    public void pageTimeOutFix() throws IOException {

        this.returnToSubject();
        select2 = driver.findElement(By.name("subjectPopUp"));
        courseSelect = new Select(select2);
        String j = Integer.toString(keepTrack);
        courseSelect.selectByValue(j);

        submitCourse = driver.findElement(By.name("3.10.7.5"));
        submitCourse.click();

        List<WebElement> courseCode = getCourseCodeElement();
        if (courseCode.isEmpty()) {
            System.out.println("----------NO COURSES FOUND----------");
        } else {
            for (int i = keepTrack2; i < courseCode.size(); i++) {
                String[] result = new String[courseCode.size()];
                result[i] = printCourseCode(i) + " - " + printCourseTitle(i);
                System.out.println(result[i]);
//                printWriter.println(result[i]);

                if (i == 0) {
                    clickOnCourseScheduleLink(i);
                } else {
                    clickOnCourseScheduleLink(i + i);
                }

                System.out.println("[" + getCourseDescription() + "]");
                
                keepTrack2 = i;
                keepTrack2++;
                driver.navigate().back();
                driver.navigate().refresh();
                if (driver.findElements(By.cssSelector("td[width='16%']")).isEmpty()) {
                    System.out.println("Page timed out"); // message to let me know if page has timed out
                    this.pageTimeOutFix();
                    break;
                }
            }
        }
    }
}
