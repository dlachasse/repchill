/*--- Server File Funcs ---*/
function ShowDrawingFiles(pn, elementID) {
    if (pn == 'header_drawings') { //if the header
        pn = document.getElementById("pn").value;
    }
    $("#drawingData").load("./func_incs/gui/FileLinksQTip.php", {
        pn: pn
    }, function(response) {
        $("#"+elementID).qtip({
          content: response,
            position: {
              corner: {
                 target: 'center',
                 tooltip: 'topLeft'
              }
          },
          show: {
            ready: true,
            solo: true,
            effect: { type: 'slide' }
          },
          hide: { when: { event: 'unfocus' } },
          style: {
            name: 'green',
            width: { min: 300 }
          }
        });
    });
}
/*--- END Server File Funcs ---*/



/*--- Edit PN Button Funcs ---*/

function ToggleEditPN(){
  $.get("./func_incs/gui/pnValidator.php",{pn: document.getElementById("pn").value,valNow: "True"},function(data){
    if(data.length>5){
     ShowEditPN();
    }
    else{
      HideEditPN();
    }
  });
}

function ShowEditPN(){
  var delaytime = 500; //ms

  var editbtn = document.getElementById("createNeditSpace");
  editbtn.style.visibility = 'visible';

  var leftVal = editbtn.style.left
  if (leftVal.indexOf('x') == -1){
    editbtn.style.left='0px';
    leftVal = editbtn.style.left;
  }
  else{
    leftVal=leftVal.replace("px","");
  }

  if (parseInt(leftVal,10) == 0 || parseInt(leftVal,10) <= 50){
    $('#createNeditSpace').animate({
      left: '50'
      }, 800, function(){
      editbtn.style.zIndex = 1; //move button to front so it can be clicked and hovered
    });
  }
} 

function HideEditPN(){
  var editbtn = document.getElementById("createNeditSpace");
  editbtn.style.zIndex = -1; //move button to be hidden in back
  
  var leftVal = editbtn.style.left;
  if (leftVal.indexOf('x') == -1){ //if no px value specifed, create it
    editbtn.style.left='0px';
    leftVal = editbtn.style.left;
  }
  else{
    leftVal=leftVal.replace("px","");
  }

  $('#createNeditSpace').animate({
    left: '0'
    }, 100, function() {
          editbtn.style.visibility = 'hidden';
    }); 
};
/*--- END Edit PN Button Funcs ---*/



/*--- Alert Window Functions ---*/
function HideDialog()
  {
    $("#overlay").hide();
    $("#dialog").fadeOut(300);
  }

function ShowDialog(modal)
  {
    $("#overlay").show();
    $("#dialog").fadeIn(300);

    if (modal)
    {
       $("#overlay").unbind("click");
    }
    else
    {
       $("#overlay").click(function (e)
       {
          HideDialog();
       });
    }
  }
/*--- End Alert Window Functions ---*/