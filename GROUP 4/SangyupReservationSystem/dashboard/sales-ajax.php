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
    <th>Bill</th>
    <th class="hidden-phone">Status</th>

    </tr>
    </thead>
    <tbody>';
    $sql = "SELECT * FROM `booking_details` WHERE res_id = '$res_id' and status = 2 and booking_date ='$sqlDate' ORDER BY make_date DESC;";
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
    ';
            
            $count++; 
           

}
$output.='
</tbody>
</table>
';
echo $output;
?>