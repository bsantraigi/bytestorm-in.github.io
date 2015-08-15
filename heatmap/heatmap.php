<?php
$servername="localhost";
$username="root";
$password="";
$dbname="grider";
$con=mysqli_connect($servername,$username,$password,$dbname);

function getdata($con)
{
    $query="select o.outlet_id,t.count,o.outlet_name,o.town,o.locality,o.state,o.pin,o.latitude,o.longitude from outlets o,(select count(*) as count,drop_id as outlet_id from grider_requests group by drop_id) as t where o.outlet_id=t.outlet_id";
    $result=mysqli_query($con,$query);
    $finalresult=array();
    $i=0;
    while($row=mysqli_fetch_assoc($result))
    {
    	$finalresult[$i++]=$row;
    }

    echo(json_encode($finalresult));
}


getdata($con);

if(isset($_POST['request']))
{
	switch ($_POST['request']) {
		case 'initial':
		getdata($con);
		break;
	}
}

?>