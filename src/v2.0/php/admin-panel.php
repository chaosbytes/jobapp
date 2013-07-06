<?php
require_once "config/db_config.php";

// admin-panel.php - used to build the admin panel client table

$link = new mysqli(HOSTNAME, DB_USER, DB_USER_PASS, DATABASE);
if (!$link->connect_errno) {
	// if $results gets back a valid response  from the MySQL query continue
	if ($results = $link->query("SELECT email, first_name, last_name, zip_code FROM clients")) {
		// build html table
		$html = "<table id='admin-table'>";
		$html .= "<thead id='admin-table-header'>";
		// column headers
		$html .= "<tr class='admin'>";
		$html .= "<th scope='col' class='colheader'>Username</th>";
		$html .= "<th scope='col' class='colheader'>First Name</th>";
		$html .= "<th scope='col' class='colheader'>Last Name</th>";
		$html .= "<th scope='col' class='colheader'>Email</th>";
		$html .= "<th scope='col' class='colheader'>Zipcode</th>";
		$html .= "<th scope='col' class='colheader'></th>";
		$html .= "</tr>";
		$html .= "</thead>";
		// column body
		$html .= "<tbody id='admin-table-body'>";
		// add empty row so even if there are no clients in the db a blank table will show up, without this the table will not load properly when insertd in the DOM
		$html .= "<tr></tr>";
		// iterate over $results and build rows concatinating them to $html
		while ($row = $results->fetch_row()) {
			// open the row and assign it an id of $row[0] which is the client username
			$html .= "<tr id='".$row[0]."'>";
			for ($i = 0; $i < count($row)+1; $i++) {
				if ($i < count($row)) {
					$html .= "<td>".$row[$i]."</td>";
				} else {
					// add a delete button at the end of each row
					$html .= "<td><input type='submit' id='".$row[0]."' class='admin-delete-button' value='Delete'></td>";
				}
			}
			// close the row
			$html .= "</tr>";
		}
		// close table body and table
		$html .= "</tbody>";
		$html .= "</table>";
		// echo back $html which is now a syntactially correct table
		echo $html;
	}
}
// close the link
$link->close();
?>