function UpdateEventTablesInHTML(user)
{
    document.querySelector("#userName").value = user.name;

    document.querySelector(".Type").innerHTML = event.type;
    document.querySelector(".StartTime").innerHTML = event.startTime;
    document.querySelector(".EndTime").innerHTML = event.endTime;
    document.querySelector(".Organization").innerHTML = event.organization;
    document.querySelector(".Presenter").innerHTML = event.presenter;
    document.querySelector(".Description").innerHTML = event.description;
}


function HandleErrors(errorMessage)
{
    eventTableArea.innerHTML = '';  //Empty the events in the event tables area
    window.alert(errorMessage);

    if (errorMessage === "Automatically sign in ...")
    {
        window.location.href=SIGN_IN_PHP_URL;
    }
    else if(errorMessage === "The session has expired or the account is not signed in")
    {
        window.location.href=SIGN_IN_PAGE_URL;
    }
}


const xmlHttp = new XMLHttpRequest();


function UpdateEventTables()
{
    xmlHttp.open("GET","Update.php?",false);
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