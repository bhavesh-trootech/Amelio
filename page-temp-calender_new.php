<?php /* Template Name: Calender Template  New*/
?>
<?php get_header(); ?>

<div class="main-wrapper">
	<div id='calendar'></div>

      <!-- Modal -->
<div id="createEventModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Schedule Session</h4>
      </div>
      <div class="modal-body">
      <form class="calendereventadd" method="post" id="calendereventadd">
            <div class="control-group">
                <label class="control-label" for="inputPatient">Session name:</label>
                <div class="field desc">
                    <input class="form-control" id="sessionname" name="sessionname" placeholder="Add session name" required type="text" value="">
                </div>
            </div><br>
            <div class="control-group">
              <?php 
              $current_user = wp_get_current_user();
              $userid=$current_user->ID;
              ?>
               <input class="form-control" id="therapistid" name="therapistid"  type="hidden" value="<?php echo $userid; ?>">
                <label class="control-label" for="inputPatient">Client email:</label>
                <div class="field desc">
                    <input class="form-control" id="clientemail" name="clientemail" placeholder="client name" required type="email" value="">
                </div>
            </div><br>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Select Date & Time:</label>
                <div class="field desc">
                    <input class="form-control" id="selectdatet" name="selectdatet" placeholder="Select Date" required type="date" value="">
                </div>
            </div><br>
            <div class="control-group">
                <label class="control-label" for="inputPatient">form time:</label>
                <div class="field desc">
                <select class="form-control" id="formtime" name="formtime" placeholder="formtime" >
                  <?php
                  $every_30_minutes = hoursRange( 0, 86400, 60 * 30, 'h:i a' );
                
                  foreach($every_30_minutes as $key=>$value){
                    ?>
                     <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php
                  }
                  ?>
               
                
                </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">To time:</label>
                <div class="field desc">
                <select class="form-control" id="totime" name="totime">
                <?php
                  $every_30_minutes = hoursRange( 0, 86400, 60 * 30, 'h:i a' );
                
                  foreach($every_30_minutes as $key=>$value){
                    ?>
                     <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php
                  }
                  ?>
                </select>
                </div>
            </div>
            
            <input type="hidden" id="startTime"/>
            <input type="hidden" id="endTime"/>    
            <input type="hidden" id="typecalender"/>       
            
            <div id="response"></div>
        </div>
      <div class="modal-footer">
        <button class="btn" id="closebtnc" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="saveclccutevnt register-btn" type="button" id="saveclccutevnt">Submit <span class="loadx loading"></span></button>
      
    </div>
  </form>
    </div>

  </div>
</div>


<div id="calendarModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="closebtncedit">&times;</button>
            <h4 class="modal-title">Event Details</h4>
        </div>
        <div id="modalBody" class="modal-body">
        <div class="control-group">
                <label class="control-label" for="inputPatient">Session name:</label>
                <div class="field desc">
                    <input class="form-control" id="editsessionname" name="editsessionname" placeholder="Add session name" readonly type="text" value="">
                </div>
            </div><br>
            <div class="control-group">
              <?php 
              $current_user = wp_get_current_user();
              $userid=$current_user->ID;
              ?>
               <input class="form-control" id="therapistid" name="therapistid"  type="hidden" value="<?php echo $userid; ?>">
                <label class="control-label" for="inputPatient">Client email:</label>
                <div class="field desc">
                    <input class="form-control" id="editclientemail" name="editclientemail" placeholder="client name" readonly type="email" value="">
                </div>
            </div><br>
            <div class="control-group">
                <label class="control-label" for="inputPatient">Select Date & Time:</label>
                <div class="field desc">
                    <input class="form-control" id="editselectdatet" name="editselectdatet" placeholder="Select Date"  readonly required type="date" value="">
                </div>
            </div><br>
            <div class="control-group">
                <label class="control-label" for="inputPatient">form time:</label>
                <div class="field desc">
           
                <input class="form-control" id="editformtime" name="editformtime" readonly placeholder="To time" type="text" value="">
               
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPatient">To time:</label>
                <div class="field desc">
                <input class="form-control" id="edittotime" name="edittotime" readonly placeholder="To time" type="text" value="">
                
                </div>
            </div>
        </div>
        <input id="custevid" name="custevid" readonly type="hidden"/>
        <input id="eventID" name="eventID" readonly type="hidden"/>

        <div id="responsed"></div>
        <div class="modal-footer">
         
            <button class="btn" type="button" id="syngoogle">sync Google Calender <span class="loadx loading"></span></button>
            <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
        </div>
    </div>
</div>
</div>
</div>
</div>
<style>

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }
  table,tr,th,td {border-color: #000 !important;}

	button#saveclccutevnt,#syngoogle {position: relative;}

		.loadx {position: absolute;
left: 0px;
top: 0px;
width: 100%;
height: 100%;
background: inherit;
display: flex;
align-items: center;
justify-content: center;
border-radius: inherit
}
p.alert.alert-danger {
    COLOR: RED;
    FONT-WEIGHT: 500;
}
.loadx::after {

content: '';

position: absolute;

border-radius: 50%;

border: 3px solid #fff;

width: 30px;

height: 30px;

border-left: 3px solid transparent;

border-bottom: 3px solid transparent;

animation: loading1 1s ease infinite;

z-index: 10

}.loadx::before {

content: '';

position: absolute;

border-radius: 50%;

border: 3px dashed #fff;

width: 30px;

height: 30px;

border-left: 3px solid transparent;

border-bottom: 3px solid transparent;

animation: loading1 2s linear infinite;

z-index: 5

}@keyframes loading1 {0% {transform: rotate(0deg)}100% {transform: rotate(360deg)}}

#saveclccutevnt.active,#syngoogle.active {transform: scale(.85)}
#saveclccutevnt.activeLoading .loading,#syngoogle.activeLoading .loading  {visibility: visible;opacity: 1}
#saveclccutevnt .loading,#syngoogle .loading {opacity: 0;visibility: hidden}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />  
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



<?php 
   global $wpdb;
   $table_name2 = $wpdb->base_prefix.'clcevent_custom';
   $current_user = wp_get_current_user();
   $userid=$current_user->ID;
   $eventlist = $wpdb->get_results("SELECT * FROM " . $table_name2 . " where `therapistid`='" .$userid. "'");
   if(!empty($eventlist)){
       $arryevent=array();
       foreach($eventlist as $elist){
           $sessionname=$elist->eventtitle;
           $startd=$elist->eventdate.'T'.$elist->eventfromtime;
           $endtd=$elist->eventdate.'T'.$elist->eventtotime;
           $desc=$elist->clientemail;
           $arryevent[]=array('title'=>$sessionname,'start'=>$startd,'end'=>$endtd,'description'=>$desc,'publicId'=>$elist->id);

       }
       $eventd=json_encode($arryevent);
  }
?>


<script>
  // var arrays = <?php //echo  $eventd; ?>;

  // var ae=array[ {
  //         title: 'All Day Event',
  //         start: '2023-01-01'
  //       },
  //       {
  //         title: 'Long Event',
  //         start: '2023-01-07',
  //         end: '2023-01-10'
  //       }]

  
  jQuery("#calendar").fullCalendar({ 
      header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay,listWeek'
      },
      editable: true,  
      navLinks: true, 
      timeFormat: 'HH:mm',
      timeZoneName: 'short',
      selectable: true,
      selectHelper: true,
    
       select: function(start, end, allDay) {
        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");  
        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");  
       
        var dateget = start.split(' ');
        var dategetsd = end.split(' ');
        jQuery('#createEventModal #startTime').val(start);
        jQuery('#createEventModal #endTime').val(end);
       // jQuery('#createEventModal #typecalender').val(arg.view.type);
         jQuery('#createEventModal #selectdatet').val(dateget[0]);
          jQuery('#createEventModal #formtime').val(dateget[1]);
          jQuery('#createEventModal #totime').val(dategetsd[1]);

        jQuery('#createEventModal').modal('toggle');
       },
       eventRender: function(event, element) {
              element.bind('dblclick', function() {
                console.log(event.id+'--'+moment(event.start).format('YYYY-MM-DD'));
              var totime=moment(event.end, 'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss');
              var fromtime=moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss');
              if(totime == 'Invalid date'){
                var totime=moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss');
              }else{
                var totime= totime;
              }
              jQuery('#calendarModal #eventID').val(event.id);
              jQuery('#calendarModal #editsessionname').val(event.title);
              jQuery('#calendarModal #editclientemail').val(event.description);
              jQuery('#calendarModal #custevid').val(event.id);
              jQuery('#calendarModal #editselectdatet').val(moment(event.start).format('YYYY-MM-DD'));
              jQuery('#calendarModal #editformtime').val(fromtime);
              jQuery('#calendarModal #edittotime').val(totime);
            
              jQuery('#calendarModal').modal('show');
              });
        }, 
        eventDrop: function(event, delta, revertFunc) {
              edit(event);
            },
          eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
              edit(event);
            },
          events: [
          <?php 
           global $wpdb;
           $table_name2 = $wpdb->base_prefix.'clcevent_custom';
           $current_user = wp_get_current_user();
           $userid=$current_user->ID;
           $eventlist = $wpdb->get_results("SELECT * FROM " . $table_name2 . " where `therapistid`='" .$userid. "'");
      
          if(!empty($eventlist)){
            foreach($eventlist as $elist): 
                $start = explode(" ", $event['start']);
                $end = explode(" ", $event['end']);
                $sessionname=$elist->eventtitle;
                $start=$elist->eventdate.'T'.$elist->eventfromtime;
                $end=$elist->eventdate.'T'.$elist->eventtotime;
                $desc=$elist->clientemail;
            ?>
            {
            id: '<?php echo $elist->id; ?>',
            title: '<?php echo $sessionname; ?>',
            start: '<?php echo $start; ?>',
            end: '<?php echo $end; ?>',
            description: '<?php echo $desc ?>',
            },
          <?php endforeach; }else {?>
           
            <?php } ?>
            ],
    
       dayMaxEvents: true,
  });

 

  jQuery(document).ready(function(){  

    jQuery('#syngoogle').on('click', function(e){
                e.preventDefault();
                jQuery('#responsed').html('');
                var text= jQuery('#editsessionname').val();

                var editformtime= jQuery('#editformtime').val();
                var editclientemail= jQuery('#editclientemail').val();
                var custevid= jQuery('#custevid').val();
                
                var edittotime= jQuery('#edittotime').val();
                var editselectdatet= jQuery('#editselectdatet').val();
                var fort = editformtime.replaceAll(":","");
                var tot = edittotime.replaceAll(":","");
                var dated = editselectdatet.replaceAll("-","");
                var udate=dated+'T'+fort;
                var udatec=dated+'T'+tot;
                var ajaxURL = "<?php echo admin_url('admin-ajax.php')?>";
                var str =  '&text=' + text + '&editformtime=' + editformtime +'&edittotime=' + edittotime+ '&clientemaiol=' + editclientemail+'&date=' + editselectdatet+
                '&custevid=' + custevid+'&action=ameliosyncgooglecalender';
                jQuery.ajax({
                  type: "POST",
                  url: ajaxURL,
                  data: str,
                  beforeSend:function(){  
                    jQuery('#syngoogle').addClass("activeLoading"); 
                  },
                  success: function(response){
                  jQuery('#syngoogle').removeClass("activeLoading");
                  if(response.success == 1){

                   
                    jQuery('#closebtncedit').trigger( "click" );
                   
                    var goourl='https://calendar.google.com/calendar/event?action=TEMPLATE&text='+text+'&dates='+udate+'/'+udatec+'&add='+editclientemail+'&details=Amelio Therapist schedual set&trp=true&sprop=http://localhost/event_cal/calender/&sf=true&';
                    var f=response.googleurl;

                    console.log(f);
                    window.open(f);
                 
                  }else{
                    jQuery('#responsed').html('<p class="alert alert-danger">'+response.message+'</p>');

                  }
              }
            })

               
               
    
    
   });
    


    jQuery('#saveclccutevnt').on('click', function(e){
                e.preventDefault();
                doAdd();
    });

    jQuery('#deleteButton').click(function(e){ 
      e.preventDefault();
        doDelete();
    });

    function doAdd(){
      var sessionname=jQuery('#sessionname').val();
        var clientemail=jQuery('#clientemail').val();
        var selectdatet=jQuery('#selectdatet').val();

        var eventfromtime=jQuery('#formtime').val();
        var eventtotime=jQuery('#totime').val();
        jQuery('#response').html('');
        if(sessionname==''){
          jQuery('#sessionname').focus();
          jQuery('#response').html('<p class="alert alert-danger">Please enter the Session Name</p>');
        }else if(clientemail==''){
          jQuery('#clientemail').focus();
          jQuery('#response').html('<p class="alert alert-danger">Please enter the Client Email</p>');

        }
        else if(selectdatet==''){
          jQuery('#selectdatet').focus();
          jQuery('#response').html('<p class="alert alert-danger">Please select the Date</p>');

        }else{
            jQuery('#response').html('');
            var formData = new FormData(jQuery('#calendereventadd')[0]);
            formData.append('action', 'amelio_caladdevent_ajax');
            var ajaxURL = "<?php echo admin_url('admin-ajax.php')?>";
            jQuery('#response').html('');
            jQuery.ajax({
              type: 'POST',
              url: ajaxURL,
              data: formData,
              processData: false,
              contentType: false,
              beforeSend:function(){  
                jQuery('#saveclccutevnt').addClass("activeLoading"); 
              },
              success: function(response){
                  jQuery('#saveclccutevnt').removeClass("activeLoading");
                  if(response.success == 1){

                    var start=selectdatet+'T'+eventfromtime;
                    var  end=selectdatet+'T'+eventtotime;
                    jQuery('#closebtnc').trigger( "click" );
                    jQuery("#calendar").fullCalendar('renderEvent',
                     {
                       id: response.id,
                       title: sessionname,
                       start: start,
                       end: end,
                       description: clientemail,
                    },
                   true);
                   alert('Added Successfully!');
                   
                    jQuery('#calendereventadd')[0].reset();
                 
                  }else{
                    jQuery('#response').html('<p class="alert alert-danger">'+response.message+'</p>');

                  }
              }
            })
          
        }

      
  }
    
      function doDelete(){
              jQuery("#calendarModal").modal('hide');
               var eventID = jQuery('#eventID').val();
               var custevid = jQuery('#custevid').val();
               var ajaxUrl = "<?php echo admin_url('admin-ajax.php')?>";
               var str =  '&id=' + custevid + '&action=deleteventcust';
               jQuery.ajax({
                type: "POST",
                  url: ajaxUrl,
                  data: str,
                  beforeSend:function(){  
                    jQuery('#saveclccutevnt').addClass("activeLoading"); 
                  },
                   success: function(response) {
                        if(response.success == 1){
                          jQuery("#calendar").fullCalendar('removeEvents',eventID);
                          alert("Deleted successfully!");
                        }
                        else {
                          return false;
                        }
                       
                           
                   }
               });
           }



});

</script>
<?php get_footer(); ?>
