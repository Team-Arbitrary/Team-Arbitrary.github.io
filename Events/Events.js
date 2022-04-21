// Configuration
const SIGN_IN_PHP_URL = "../Sign-In/Sign-In.php";
const SIGN_IN_PAGE_URL = "../Sign-In/Sign-In.html";

const xmlHttp = new XMLHttpRequest();

// 在显示页面时 和 点击更新按钮时 自动运行更新函数
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


function HandleErrors(errorMessage)
{
    eventTableArea.innerHTML = '';  //清空事件区中的事件
    window.alert(errorMessage);

    if (errorMessage === "账号刚注册但未登录，即将自动登录")
    {
        window.location.href=SIGN_IN_PHP_URL;
    }
    else if(errorMessage === "登录会话已过期 或 未登录账号")
    {
        window.location.href=SIGN_IN_PAGE_URL;
    }


    // else if(errorMessage === "! Could not find Database connection, Please contact administrator")
    // {
    //     window.location.reload();
    // }
    //
    // else if(errorMessage === "! Failed to prepare SQL statement, Please contact administrator")
    // {
    //     window.location.reload();
    // }
    //
    // else if(errorMessage === "! Failed to query the database, Please contact administrator")
    // {
    //     window.location.reload();
    // }
}

const eventTableArea = document.querySelector("div");
const eventTable = document.querySelector("table");
let eventTables = [];
function UpdateEventTablesInHTML(events)
{
    eventTables = [];
    for (const event of events) {
        // 填写每一个Event表格
        eventTable.querySelector(".ID").value = event.id;
        eventTable.querySelector(".Name").innerHTML = event.name;
        eventTable.querySelector(".Type").innerHTML = event.type;
        eventTable.querySelector(".StartTime").innerHTML = event.startTime;
        eventTable.querySelector(".EndTime").innerHTML = event.endTime;
        eventTable.querySelector(".Organization").innerHTML = event.organization;
        eventTable.querySelector(".Presenter").innerHTML = event.presenter;
        eventTable.querySelector(".Description").innerHTML = event.description;

        // 不断将新的Event表格加入eventTables数组中
        eventTables.push(eventTable.outerHTML);
    }

    eventTableArea.innerHTML = eventTables.join('');  // todo 查询 将数组中的所有值拼接成一个字符串
}


// eventTable = document.createElement("table");
// eventTableCon = document.createTextNode("");
// let eventTable = document.getElementsByTagName("table")[0];