package webscrape;

import java.io.IOException;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

public class ACTScraper {

    String LAPS = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018AP.html";
    String EDUCATION = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018ED.html";
    String ENVSTUDY = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018ES.html";
    String AMPD = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018FA.html";
    String GLENDON = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018GL.html";
    String GRADSTUDY = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018GS.html";
    String HEALTH = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018HH.html";
    String LASSONDE = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018LE.html";
    String SCHULICH = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018SB.html";
    String SCIENCE = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018SC.html";
    //    String OSGOODE = "https://apps1.sis.yorku.ca/WebObjects/cdm.woa/Contents/WebServerResources/FW2018LW.html"; NOT RELEASED YET
    private String courseName;
    private String term;

    public static void main(String[] args) throws IOException {
        ACTScraper test = new ACTScraper();
        test.connectionStart();
    }

    public void setCourseName(String input) {
        courseName = input;
    }
    
    public String getCourseName() {
        return courseName;
    }
    
    public void setTerm(String input) {
        term = input;
    }
    
    public String getTerm() {
        return term;
    }

    public void connectionStart() throws IOException {
        String timetableFaculty[] = {LAPS, EDUCATION, ENVSTUDY, AMPD, GLENDON, GRADSTUDY, HEALTH, LASSONDE, SCHULICH, SCIENCE};

        for (int i = 0; i < timetableFaculty.length; i++) {

            Document doc = Jsoup.connect(timetableFaculty[i])
                    .timeout(6000)
                    .maxBodySize(0)
                    .get();

            Elements rows = doc.select("tr");

            for (int k = 2; k < rows.size(); k++) {
                Elements tdTags = rows.get(k).select("td");
                /*
                does td tag have class 'bodytext'
                if so it implies we're grabbing faculty, dept, term, and course title information
                store this into a string so we can use it to update the DB
                 */
                if (tdTags.hasClass("bodytext")) {
//                    String faculty = tdTags.get(0).text();
//                    setTitle(faculty + "/" + term + "  " + tdTags.get(1).text() + "  " + tdTags.get(3).text() + "  ");
//                    System.out.print(faculty + "/" + term + "  " + tdTags.get(1).text() + "  " + tdTags.get(3).text() + "  ");
                    setTerm(tdTags.get(2).text());
                    setCourseName(tdTags.get(3).text());
                    System.out.print(getTerm() + " - " + getCourseName());
//                    System.out.print(rows.get(k).text());
                } else {
                    if (tdTags.size() > 4) {
                        System.out.print("Term " + getTerm() + " - " + rows.get(k).text() + " ");
                    }
                }
                System.out.println();
            }
//            System.out.println("Row size: " + rows.size());
            System.out.println("--------------------------------------------------------------------------------------");
        }
    }
}
