<?php

	/*
	My Stuff -project main page.
	Copyright (C) 2009 Aleksi Räsänen <aleksi.rasanen@runosydan.net>
	 
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	*/	

	session_start();
	require 'general_functions.php';

	function show_main_page()
	{
		$catalogs = get_catalogs();

		if( count( $catalogs ) == 0 )
		{
			echo 'No catalogues found.<br /><br />';
		}
		else
		{
			echo '<div id="list_catalogs">';
			echo '<table>';

			foreach( $catalogs as $tmp )
			{
				$name_tmp = explode( '.', $tmp );
				$name = $name_tmp[0];

				echo '<tr>';
				echo '<td>';
				echo '<a href="catalogs.php?catalog=' . $tmp . '">'
					. $name . '</a><br />';
				echo '</td>';
				echo '<td width="20%">';
				echo '<a href="remove.php?catalog=' . $tmp . '">Delete</a>';
				echo '</td>';
				echo '</tr>';
			}
			echo '</table>';
			echo '</div>';
		}

		echo '<div id="main_links">';
		echo '<a href="edit_catalogues.php">Create new catalog</a>';
		echo '<a href="logout.php">Logout</a>';
		echo '</div>';
	}

	function main()
	{
		create_html_start();

		if(! isset( $_SESSION['ms_username'] ) )
			show_login();
		else
			show_main_page();

		create_html_end();
	}

	main();
?>
