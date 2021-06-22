<?PHP

function byte_to_gb($size){
	if($size < 0){
		return "unlimited";
	}else {
		return round($size/(1024*1024*1024),5)."GB";
	}
}
}


echo '
<html>
<head>
	<title>traffic monitor</title>
	<meta charset=UTF-8"/>  
</head>
';

$servername = "localhost";
$username = "trojan";
$password = "trojan";
 
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
	    die("database connection failed:" . $conn->connect_error);
} 
echo "database connection succeed";

$sql="select username,quota,upload,download from trojan.users";
$result=$conn->query($sql);


echo "
<body>
<table border='2' cellspacing='0' cellpadding='5'>
	<tr>
		<th>username</th>
		<th>quota</th>
		<th>upload</th>
		<th>download</th>
		<th>used(download+upload)</th>
	</tr>";

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
		echo "
		<tr>
			<td>".$row["username"]."</td>
			<td>".byte_to_gb($row["quota"])."</td>
			<td>".byte_to_gb($row["upload"])."</td>
			<td>".byte_to_gb($row["download"])."</td>
			<td>".byte_to_gb($row["upload"]+$row["download"])."</td>
		</tr>
		";
	}
} else {
	echo "<tr>No Result Found</tr>";
}


echo "</table>";
echo "<p style='color:red'>User can access trojan.service only if his/her upload + download <= quota, download and upload will be set to ZERO on 1st of every month</p>";
echo "</body></html>"


?>
