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
        else  // The content in responseText is the error message transmitted by the server, not the data in JSON format
        {
            HandleErrors(xmlHttp.responseText);
        }
    }
    catch(exception)  // The content in responseText is the error message transmitted by the server, not the data in JSON format, and does not meet the format requirements of the input content of JSON.parse()
    {
        HandleErrors(xmlHttp.responseText);
    }
}


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
        return true;  // The browser automatically refreshes the page
    }
    return false;  // Deny the browser to automatically refresh the page
}