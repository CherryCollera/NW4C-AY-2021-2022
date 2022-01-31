<?php
session_start();
    $sqlDate = $_POST['date'];
    $count = 1;
    include 'dbCon.php';
    $con = connect();
    $res_id = $_SESSION['id'];
    $output;
    $output ='<table class="table table-bordered table-striped mb-none" name="datatable-tabletools" id="datatable-tabletools" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
    <thead>
        <tr>
            <th>No</th>
            <th>Booking Id</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Date</th>
            <th>Time</th>
            
            <th class="hidden-phone">Status</th>
            <th class="hidden-phone">Action</th>
            <th class="hidden-phone">View</th>
        </tr>
    </thead>
    <tbody>';
    $sql = "SELECT * FROM `booking_details` WHERE res_id = '$res_id' and type=0 and booking_date ='$sqlDate' ORDER BY make_date DESC;";
    $result = $con->query($sql);
    foreach ($result as $r) {
        $output.='
    
    <tr class="gradeX">
        <td class="center hidden-phone">'.$count.'</td>
        <td class="center hidden-phone">'.$r["booking_id"].'</td>
        <td>'. $r["name"].'</td>
        <td>'.$r["phone"].'</td>
        <td>'. $r["booking_date"].'</td>
        <td>'. $r["booking_time"].'</td>
        <td> ₱ '.$r["bill"].'</td>
        <td class="center hidden-phone">';

                $status = $r["status"];
            if ($status == 0) {
        $output.='
            <p class="text-dark">Pending</p>';
           }else if($status == 1){
            $output.='  <p class="text-info">Confirmed</p>';
            }elseif($status == 2){
            $output.='
            <p class="text-success">Done</p>';
             }elseif($status == 3){ 
             $output.='
            <p class="text-warning">Cancelled</p>';
            }else if($status == 4){ 
            $output.='
                <p class="text-danger">Rejected</p>';
            }
            $output.='
        </td>
        <td class="center hidden-phone">
    ';

    
            $rfeestatus = $r['rfeestatus'];
            if ($rfeestatus == 1) {
 
      
            if ($status == 0) {
                $output.='  
          <a href="approve-reject.php?bapprove_id='.$r['id'].'&booking-number='.$r['booking_id'].'" class="btn btn-success"  onclick="if (!Done()) return false; ">Confirm</a>';
         }else if($status == 1){ 
            $output.='
            <a href="approve-reject.php?bdone_id='.$r['id'].'&booking-number='. $r['booking_id'].'" class="btn btn-success"  onclick="if (!Done()) return false; ">Done</a>';
            } 
            } else{
                $output.='
            <p class="text-danger">Reservation Fee Not Paid</p>';
         } 
   
    $output.='
    </td>
    <td class="center hidden-phone">
        <a href="invoice.php?booking-number='. $r['booking_id'].'" class="btn btn-primary">View</a>
        <a href="notify.php?booking-number='. $r['booking_id'].'" class="btn btn-primary">Notify</a>
    </td>
</tr>';
            $count++; 
           

}
$output.='
</tbody>
</table>
';
echo $output;
?>