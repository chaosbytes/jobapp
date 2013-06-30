<?php
require "connect.php";

$link = connect();

if (!$link->ping()) {
	echo json_encode(array("status" => false, "error" => $link->error));
} else if ($link) {
		$sql = "SELECT username, fname, lname, email, zipcode FROM clients";
		if ($results = $link->query($sql)) {
			$html = "<table id='admin-table'>";
			$html = $html."<thead id='admin-table-header'>";
			$html = $html."<tr class='admin'>";
			$html = $html."<th scope='col' class='colheader'>Username</th>";
			$html = $html."<th scope='col' class='colheader'>First Name</th>";
			$html = $html."<th scope='col' class='colheader'>Last Name</th>";
			$html = $html."<th scope='col' class='colheader'>Email</th>";
			$html = $html."<th scope='col' class='colheader'>Zipcode</th>";
			$html = $html."<th scope='col' class='colheader'></th>";
			$html = $html."</tr>";
			$html = $html."</thead>";
			$html = $html."<tbody id='admin-table-body'>";
			$html = $html."<tr></tr>";
			
			while ($row = $results->fetch_row()) {
				$html = $html."<tr id='".$row[0]."'>";
				for ($i = 0; $i < count($row)+1; $i++) {
					if($i < count($row)){
					$html = $html."<td>".$row[$i]."</td>";
					} else {
						$html = $html."<td><input type='submit' id='".$row[0]."' class='admin-delete-button' value='Delete'></td>";
					}
				}
				$html = $html."</tr>";
			}
			$html = $html."</tbody>";
			$html = $html."</table>";
			echo $html;
		}
	}
$link->close();
?>