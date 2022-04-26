// Configuration
const SIGN_IN_PHP_URL = "../Sign-In/Sign-In.php";
const SIGN_IN_PAGE_URL = "../Sign-In/Sign-In.html";


const eventTableArea = document.querySelector('div[id="events-wrapper"]');
const eventTable = document.querySelector("table");
let eventTables = [];
function UpdateEventTablesInHTML(events)
{
    eventTables = [];
    for (const event of events) {
        // Fill out each Event Form
        eventTable.querySelector(".ID").value = event.id;
        eventTable.querySelector(".Name").innerHTML = event.name;
        eventTable.querySelector(".Type").innerHTML = event.type;
        eventTable.querySelector(".StartTime").innerHTML = event.startTime;
        eventTable.querySelector(".EndTime").innerHTML = event.endTime;
        eventTable.querySelector(".Organization").innerHTML = event.organization;
        eventTable.querySelector(".Presenter").innerHTML = event.presenter;
        eventTable.querySelector(".Description").innerHTML = event.description;

        // Constantly add new Event tables to the eventTables array
        eventTables.push(eventTable.outerHTML);
    }

    eventTableArea.innerHTML = eventTables.join('');  //Concatenates all values in an array into a string
}


function HandleErrors(errorMessage)
{
    eventTableArea.innerHTML = '';  //Empty the events in the event tables area
    window.alert(errorMessage);

    switch (errorMessage) {
        case "Automatically sign in ...":
            window.location.href=SIGN_IN_PHP_URL;
            break;
        case "The session has expired or the account is not signed in":
            window.location.href=SIGN_IN_PAGE_URL;
    }
}


const xmlHttp = new XMLHttpRequest();


const updateButton = document.querySelector("#updateButton");
function UpdateEventTables()
{
    xmlHttp.open("GET","Update.php?",false);

    updateButton.disabled=true;
    xmlHttp.send();

    try
    {
        const events = JSON.parse(xmlHttp.responseText);
        if(typeof events == 'object' && events)
        {
            UpdateEventTablesInHTML(events);
        }
        else  // The content in responseText is the error message transmitted by the server, not the data in JSON format
        {
            HandleErrors(xmlHttp.responseText);
        }
    }
    catch(exception)  // The content in responseText is the error message transmitted by the server, not the data in JSON format, and does not meet the format requirements of the input content of JSON.parse()
    {
        HandleErrors(xmlHttp.responseText);
    }
    updateButton.disabled=false;
}


function DeleteEventTable(formElement)
{
    if (window.confirm("Are you sure you want to delete this event?"))
    {
        xmlHttp.open("POST","Delete.php",false);
        const deleteButton = formElement.querySelector(".DeleteButton");

        deleteButton.disabled=true;
        xmlHttp.send(new FormData(formElement));

        window.alert(xmlHttp.responseText);
        deleteButton.disabled=false;
        return true;  // The browser automatically refreshes the page
    }
    return false;  // Deny the browser to automatically refresh the page
}