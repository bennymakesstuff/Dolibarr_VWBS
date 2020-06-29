//This file contains all of the WBS Module Javascript Code

//This function requests the list of children for the parent number
/*function loadWBSList(parentNumber = 0){

  $.post(JSCore.url+'/custom/wbs/loadWBS.php',{wbs_parent:parentNumber})
    .done(function(data){
        console.log(JSON.parse(data));
    })
    .fail(function(){
        console.log("FAILURE: Loading Page Content");
    })
}
*/
// This function WBS Version data wrapped in a promise from a JSON source
async function loadWBSVersions(){
  JSCore.log('Loading WBS Versions','syslog');
  JSCore.log('Loading WBS Versions','console');
  var responseData = await Promise.resolve(
    $.get(JSCore.url+'/custom/wbs/loadWBSVersions.php')
    .then(function(data){
        var parsedData = JSON.parse(data);
        console.log(parsedData);
        return parsedData;
    })).catch(function(e){
          return("Failed: "+e.status+" - "+e.responseText);
        });
    return responseData;
}


// This function gets or posts data wrapped in a promise from a JSON source
async function getWBSName(parentNumber = 0){
  var newParentNumber = parseInt(parentNumber);
  var responseData = await Promise.resolve(
    $.post(JSCore.url+'/custom/wbs/loadWBSName.php',{wbs_parent:newParentNumber})
    .then(function(data){
        var parsedData = JSON.parse(data);
        console.log(parsedData);
        return parsedData;
    })).catch(function(e){
          return("Failed: "+e.status+" - "+e.responseText);
        });
    return responseData;
}


// This function gets or posts data wrapped in a promise from a JSON source
async function loadWBSList(parentNumber = 0, checkFirst = false){
  console.log("WBS Number"+parentNumber);
  var responseData = await Promise.resolve(
    $.post(JSCore.url+'/custom/wbs/loadWBS.php',{wbs_parent:parentNumber,wbs_checkFirst:checkFirst})
    .then(function(data){
        var parsedData = JSON.parse(data);
        console.log(parsedData);
        return parsedData;
    })).catch(function(e){
          return("Failed: "+e.status+" - "+e.responseText);
        });
    return responseData;
}


async function loadListOne(){
  var vwbsCategoryOneList = await loadWBSList(1,true);
  console.log(vwbsCategoryOneList.payload);
  var list = '';
  for(i = 0;i<vwbsCategoryOneList.payload.length;i++){
    //console.log(i);
    vwbsCategoryOneList.payload[i].description = JSCore.toTitleCase(vwbsCategoryOneList.payload[i].description);
    list += "<div class='vwbsListItem' onClick='loadListTwo("+vwbsCategoryOneList.payload[i].rowid+")' data-value='"+vwbsCategoryOneList.payload[i].vwbscode+"' title='"+vwbsCategoryOneList.payload[i].vwbscode+" - "+vwbsCategoryOneList.payload[i].description+"'>"+vwbsCategoryOneList.payload[i].description+"</div>";
  }
  var htmlList = $.parseHTML(list);

  $("#vwbsListOne").empty().append(htmlList);
}


async function loadListTwo(parentNumber){
  var vwbsCategoryOneList = await loadWBSList(parentNumber);
  console.log(vwbsCategoryOneList.payload);
  var list = '';
  for(i = 0;i<vwbsCategoryOneList.payload.length;i++){
    //console.log(i);
    vwbsCategoryOneList.payload[i].description = JSCore.toTitleCase(vwbsCategoryOneList.payload[i].description);
    list += "<div class='vwbsListItem' onClick='loadListThree("+vwbsCategoryOneList.payload[i].rowid+")' data-value='"+vwbsCategoryOneList.payload[i].vwbscode+"' title='"+vwbsCategoryOneList.payload[i].vwbscode+" - "+vwbsCategoryOneList.payload[i].description+"'>"+vwbsCategoryOneList.payload[i].description+"</div>";
  }
  var htmlList = $.parseHTML(list);
  $("#vwbsListThree").empty();
  $("#vwbsListTwo").empty().append(htmlList);
}

async function loadListThree(parentNumber){
  var vwbsCategoryOneList = await loadWBSList(parentNumber);
  console.log(vwbsCategoryOneList.payload);
  var list = '';
  for(i = 0;i<vwbsCategoryOneList.payload.length;i++){
  //  console.log(i);
    vwbsCategoryOneList.payload[i].description = JSCore.toTitleCase(vwbsCategoryOneList.payload[i].description);
    list += "<div class='vwbsListItem' onClick='selectListThree(parseInt("+vwbsCategoryOneList.payload[i].rowid+"),\""+vwbsCategoryOneList.payload[i].description+"\")' data-value='"+vwbsCategoryOneList.payload[i].vwbscode+"' title='"+vwbsCategoryOneList.payload[i].vwbscode+" - "+vwbsCategoryOneList.payload[i].description+"'>"+vwbsCategoryOneList.payload[i].description+"</div>";
  }
  var htmlList = $.parseHTML(list);
  $("#vwbsListThree").empty().append(htmlList);
}


function selectListThree(vwbsNumber,vwbsName){
  $('#options_fk_vwbs').val(vwbsNumber);
  $('#vwbsButton').html(vwbsNumber+' - '+vwbsName);
  JSCore.log('Closed WBS Selector','syslog');
  $('#vwbsBox').removeClass('shown').addClass('hidden');
}


$(document).ready(function(){
  JSCore.log("URL: "+JSCore.fullpath,"syslog");
  if(findNeedle("projet/tasks.php",JSCore.fullpath) && (findNeedle("create",JSCore.fullpath)||findNeedle("edit",JSCore.fullpath))){
    initializeTaskCreatePage();
  }
  else if(findNeedle("projet/tasks.php",JSCore.fullpath) && (findNeedle("task.php?id=",JSCore.fullpath))){
    initializeTaskListPage();
  }
  else if((findNeedle("projet/card.php",JSCore.fullpath) && (findNeedle("create",JSCore.fullpath)||findNeedle("edit",JSCore.fullpath)))||JSCore.pathOnly == "/projet/card.php"){
    JSCore.log("Attaching WBS Module","syslog");
    initializeProjectCreatePage();
  }
  else{
    //Do nothing
  }

});

function initializeProjectCreatePage(){
  var wbsField = $('#options_vwbs_version');
  var wbsParent = wbsField.parent();

  // Hide the original field by setting to input type hidden.
  // It is still needed for collecting the final value in the database.
  wbsField.attr('type','hidden');

  var wbsDropdown = "<div class='wbsOuter'>";
      wbsDropdown += "<button id='vwbsButton'>Select WBS Version</button>";
      wbsDropdown += "<div id='vwbsBox' class='hidden'>";
      wbsDropdown += "<div id='vwbsTitle'>";
      wbsDropdown += "Select a VWBS Version";
      wbsDropdown += "</div>";
      wbsDropdown += "<div id='vwbsClose'>";
      wbsDropdown += "x";
      wbsDropdown += "</div>";
      wbsDropdown += "<div id='vwbsMiddle'>";
      //VWBS Page Here
      wbsDropdown += "</div>";
      wbsDropdown += "<div id='vwbsBottom'>";
      wbsDropdown += "</div>";
      wbsDropdown += "</div>";
      wbsDropdown += "</div>";

  var  wbsDropdownHtml = $.parseHTML(wbsDropdown);

  wbsParent.append(wbsDropdownHtml);
  JSCore.log("Appending VWBS Version Button","syslog");

  $(document).on('click','#vwbsButton',function(e){
    e.preventDefault();
    JSCore.log('Opened WBS Version Selector','syslog');
    $('#vwbsBox').removeClass('hidden').addClass('shown');
  });

  $(document).on('click','#vwbsClose',function(e){
    e.preventDefault();
    JSCore.log('Closed WBS Selector','syslog');
    $('#vwbsBox').removeClass('shown').addClass('hidden');
  });
}


function initializeTaskListPage(){
  var vwbsStage = $('.project_task_extras_fk_vwbs').first();
  var vwbsNumber = parseInt(vwbsStage.html());
  vwbsStage.html('<div class="lds-facebook"><div></div><div></div><div></div></div>');
  var vwbsName = getWBSName(vwbsNumber).then(function(result){
    vwbsStage.html(result.payload.description+' ('+result.payload.vwbscode+')');
    console.log(result.payload);
  });
}


function initializeTaskCreatePage(){

  JSCore.log('Tasks Page Loaded','syslog');

  var vwbsDropdown = "<div class='vwbsOuter'>";
      vwbsDropdown += "<button id='vwbsButton'>Select WBS Stage</button>";
      vwbsDropdown += "<div id='vwbsBox' class='hidden'>";
      vwbsDropdown += "<div id='vwbsTitle'>";
      vwbsDropdown += "Select a WBS Category";
      vwbsDropdown += "</div>";
      vwbsDropdown += "<div id='vwbsClose'>";
      vwbsDropdown += "x";
      vwbsDropdown += "</div>";
      vwbsDropdown += "<div id='vwbsMiddle'>";
      vwbsDropdown += "<div class='vwbsListTitle'>Category 1";
      vwbsDropdown += "</div>";
      vwbsDropdown += "<div class='vwbsListTitle'>Category 2";
      vwbsDropdown += "</div>";
      vwbsDropdown += "<div class='vwbsListTitle lastTitle'>Category 3";
      vwbsDropdown += "</div>";
      vwbsDropdown += "<div class='vwbsList' id='vwbsListOne'>";
      vwbsDropdown += "</div>";
      vwbsDropdown += "<div class='vwbsList' id='vwbsListTwo'>";
      vwbsDropdown += "</div>";
      vwbsDropdown += "<div class='vwbsList' id='vwbsListThree'>";
      vwbsDropdown += "</div>";
      vwbsDropdown += "</div>";
      vwbsDropdown += "<div id='vwbsBottom'>";
      vwbsDropdown += "</div>";
      vwbsDropdown += "</div>";
      vwbsDropdown += "</div>";

  var  vwbsDropdownHtml = $.parseHTML(vwbsDropdown);

  var select_object = $.parseHTML("<select name='' id='vwbs_selector'></select>");
  // Assign vwbs textbox to an object
  var vwbs_field = $('#options_fk_vwbs');

  // Assign vwbs parent div to an object
  var vwbs_parent = vwbs_field.parent();

  // Hide the vwbs textbox
  vwbs_field.attr({'type': 'hidden'});

  //Append the first select box to the VWBS Area
  vwbs_parent.append(vwbsDropdown);

  loadListOne();
  // Initially this will only request VWBS data for the Child Of Level 1 (Whole Vehicle).
  // Expects Return of 100,200,300 ... etc.

  $(document).on('click','#vwbsButton',function(e){
    e.preventDefault();
    JSCore.log('Opened WBS Selector','syslog');
    $('#vwbsBox').removeClass('hidden').addClass('shown');
  });

  $(document).on('click','#vwbsClose',function(e){
    e.preventDefault();
    JSCore.log('Closed WBS Selector','syslog');
    $('#vwbsBox').removeClass('shown').addClass('hidden');
  });

  $(document).on('click','.vwbsListItem',function(e){
    JSCore.log('Selected','syslog');
    $(e.target).parent().children().removeClass('itemselected');
    $(e.target).addClass('itemselected');
  });

  $(document).on('click','#vwbs_selector',function(e){
      console.log(e.target.value);
      vwbs_field.val(e.target.value);
  });

}
