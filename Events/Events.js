// Configuration
const SIGN_IN_PHP_URL = "../Sign-In/Sign-In.php";
const SIGN_IN_PAGE_URL = "../Sign-In/Sign-In.html";


const eventTableArea = document.querySelector("div");
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

    eventTableArea.innerHTML = eventTables.join('');  // todo 查询 将数组中的所有值拼接成一个字符串
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
        else  // responseText 中的内容，是服务器传输的错误信息，不是 JSON 形式的数据
        {
            HandleErrors(xmlHttp.responseText);
        }
    }
    catch(exception)  // responseText 中的内容，是服务器传输的错误信息，不是 JSON 形式的数据，并且不符合 JSON.parse() 的输入内容的格式要求
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
        return true;  // 浏览器自动刷新页面
    }
    return false;  // 拒绝浏览器自动刷新页面
}