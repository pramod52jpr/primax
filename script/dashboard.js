$(document).ready(()=>{
    $(".projectList").slideUp(0);
    $(".dropdown").click(()=>{
        $(".projectList").slideToggle(200);
    })
})

// project search

function searchProject(){
    var searchInput=document.getElementById("search").value;
    var projectData=document.getElementsByClassName("projectData");
    for(var i=0;i<projectData.length;i++){
        if(projectData[i].innerText.toLowerCase().search(searchInput.toLowerCase())!=-1){
            projectData[i].style.display="";
        }else{
            projectData[i].style.display="none";
        }
    }
}

// document search

function searchDocument(){
    var searchInput=document.getElementById("searchDoc").value;
    var documentData=document.getElementsByClassName("documentData");
    for(var i=0;i<documentData.length;i++){
        if(documentData[i].innerText.toLowerCase().search(searchInput.toLowerCase())!=-1){
            documentData[i].style.display="";
        }else{
            documentData[i].style.display="none";
        }
    }
}

// drawing search

function searchDrawing(){
    var searchInput=document.getElementById("searchDraw").value;
    var drawingData=document.getElementsByClassName("drawingData");
    for(var i=0;i<drawingData.length;i++){
        if(drawingData[i].innerText.toLowerCase().search(searchInput.toLowerCase())!=-1){
            drawingData[i].style.display="";
        }else{
            drawingData[i].style.display="none";
        }
    }
}

// projects in master data

function searchAllProjects(){
    var searchInput=document.getElementById("searchAllProjects").value;
    var allProjectData=document.getElementsByClassName("allProjectData");
    for(var i=0;i<allProjectData.length;i++){
        if(allProjectData[i].innerText.toLowerCase().search(searchInput.toLowerCase())!=-1){
            allProjectData[i].style.display="";
        }else{
            allProjectData[i].style.display="none";
        }
    }
}

// users in master data

function searchAllUsers(){
    var searchInput=document.getElementById("searchAllUsers").value;
    var allUsersData=document.getElementsByClassName("allUsersData");
    for(var i=0;i<allUsersData.length;i++){
        if(allUsersData[i].innerText.toLowerCase().search(searchInput.toLowerCase())!=-1){
            allUsersData[i].style.display="";
        }else{
            allUsersData[i].style.display="none";
        }
    }
}

// download all po files

function downloadAllFiles(){
    var allFiles=document.getElementsByClassName("downloadAll");
    for (let i = 0; i < allFiles.length; i++) {
        const element = allFiles[i];
        element.click();
    }
}