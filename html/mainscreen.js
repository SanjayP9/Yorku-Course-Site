/**
 * Created by Sanjay on 2/21/2018.
 */
var input = "";
var resultText = "";
var text = document.getElementById("results");
var ajax;
function getInput(){
    var input = document.getElementById("searchForm");
    return input;
}
function getFromServer(url, cFunction){/*function to query the server, recieves two inputs, one the url/sql query to query from and
 2 the function attempting to call from the server for specific outputs, eg for the course result or preview
 */
    ajax = new XMLHttpRequest();
    ajax.onreadystatechange = ajaxReady;
    ajax.open("GET", url , true);
    ajax.send(null); //dont send anything back to the server

    function ajaxReady() {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("display1").innerHTML = this.responseText
            cFunction(this);
        }
    }

    function getText(ajax){
        resultText = ajax.responseText;
        var toSplit = resultText.split(/n);
        //splits it based on output recieved from server
        for (i = 0, i < toSplit.length; i ++){
            //loops through array of possible results and prints each one in a new div
            var newDiv = document.createElement("div");
            var content = document.createNewTextNode(toSplit[i]);
            var results = newDiv.appendChild(content);
            text.appendChild(results);
            //append results to html file
        }

    }
    function getPreview(ajax){
        resultText = ajax.responseText;
        document.getElementById("preview").innerHTML = resultText;
    }



function getCourses (){
    // GET array with SQL

}

function setInput (){
    inputText = document.getElementById('inputBox');
}