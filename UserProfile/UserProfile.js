function UpdateUserInformationInHTML(user)
{
    document.querySelector("#userName").value = user.name;

    switch (user.status) {
        case "Full-Time":
            document.querySelector("#full-TimeStatus").checked = true;
            break;
        case "Adjunct":
            document.querySelector("#adjunctStatus").checked = true;
            break;
        case "Uncertain":
            document.querySelector("#uncertainStatus").checked = true;
    }

    document.querySelector("#email").value = user.email;
}


function HandleErrors(errorMessage)
{
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


function UpdateUserInformation()
{
    xmlHttp.open("GET","Update.php?",false);
    xmlHttp.send();

    try
    {
        const user = JSON.parse(xmlHttp.responseText);
        if(typeof user == 'object' && user)
        {
            UpdateUserInformationInHTML(user[0]);
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

// Todo 修改
function ChangeUserInformation(formElement)
{
    if (window.confirm("Are you sure you want to Change Your Information?"))
    {
        xmlHttp.open("POST","Change.php",false);
        const changeButton = formElement.querySelector("#ChangeButton");

        changeButton.disabled=true;
        xmlHttp.send(new FormData(formElement));

        window.alert(xmlHttp.responseText);
        changeButton.disabled=false;
        return true;  // 浏览器自动刷新页面
    }
    return false;  // 拒绝浏览器自动刷新页面
}