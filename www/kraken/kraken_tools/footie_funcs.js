//youtube goodness
  var player;
  function onPlayerReady(event) {
    var embedCode = event.target.getVideoEmbedCode();
    event.target.playVideo();
    if (document.getElementById('embed-code')) {
      //document.getElementById('embed-code').textContent = embedCode;
    }
  }
    function onYouTubePlayerAPIReady() {
      player = new YT.Player('player', {
        events: {
          'onReady': onPlayerReady
        }
      });
    }
    function jqalert(data) {
      document.getElementById('alertText').innerHTML=data;
      $( "#dialog-confirm" ).dialog({
        resizable: false,
        height:225,
        width:350,
        modal: true,
        buttons: {
          "GitSum": function() {
            $( this ).dialog( "close" );
          },
          Cancel: function() {
            $( this ).dialog( "close" );
          }
        },
        close: function(event, ui) { window.location.href = window.location.pathname; }
      });
    }

    function updateAttendance(player,sub,attending,echo){
      $.get("./kraken_tools/updateAttendance.php", { player: player, sub: sub, attending: attending, echo: echo  },
       function(data){
        jqalert(data); //output is the current position, if any is stored (left,right,top)
       });
    }

    function hideStuff(id) {
      document.getElementById(id).style.display = 'none';
    }
    function RemoveSub(player){
      updateAttendance(player,'true','no','true');
    }
    function AddSub(){
      var player = document.getElementById('sub').value;
      updateAttendance(player,'true','true','true');
    }