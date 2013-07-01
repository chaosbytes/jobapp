<?php
// admin-panel.php - used to build the admin panel client table
// require MySQL connection function
require "connect.php";
// open a link to MySQL
$link = connect();
// if link has no valid connection
if (!$link->ping()) {
	//echo an error response
	echo json_encode(array("status" => false, "error" => $link->error));
} else if ($link) {
		// else if link is valid
		// setup sql statement
		$sql = "SELECT username, fname, lname, email, zipcode FROM clients";
		// if $results gets back a valid response  from the MySQL query continue
		if ($results = $link->query($sql)) {
			// build html table
			$html = "<table id='admin-table'>";
			$html = $html."<thead id='admin-table-header'>";
			// column headers
			$html = $html."<tr class='admin'>";
			$html = $html."<th scope='col' class='colheader'>Username</th>";
			$html = $html."<th scope='col' class='colheader'>First Name</th>";
			$html = $html."<th scope='col' class='colheader'>Last Name</th>";
			$html = $html."<th scope='col' class='colheader'>Email</th>";
			$html = $html."<th scope='col' class='colheader'>Zipcode</th>";
			$html = $html."<th scope='col' class='colheader'></th>";
			$html = $html."</tr>";
			$html = $html."</thead>";
			// column body
			$html = $html."<tbody id='admin-table-body'>";
			// add empty row so even if there are no clients in the db a blank table will show up, without this the table will not load properly when insertd in the DOM
			$html = $html."<tr></tr>";
			// iterate over $results and build rows concatinating them to $html 
			while ($row = $results->fetch_row()) {
				// open the row and assign it an id of $row[0] which is the client username
				$html = $html."<tr id='".$row[0]."'>";
				for ($i = 0; $i < count($row)+1; $i++) {
					if($i < count($row)){
					$html = $html."<td>".$row[$i]."</td>";
					} else {
						// add a delete button at the end of each row
						$html = $html."<td><input type='submit' id='".$row[0]."' class='admin-delete-button' value='Delete'></td>";
					}
				}
				// close the row
				$html = $html."</tr>";
			}
			// close table body and table
			$html = $html."</tbody>";
			$html = $html."</table>";
			// echo back $html which is now a syntactially correct table
			echo $html;
		}
	}
	// close the link
$link->close();
?>