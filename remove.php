<?php

	/*
	Catalog viewing and editing file. Part of My Stuff -project.
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

	function show_confirmation_form( $file )
	{
		echo '<div id="confirmation">';
		echo 'Are you sure that you want to remove catalog <i>'
			. $file . '</i><br /> and all of its content?<br /><br />';

		echo '<center>';
		echo '<a href="remove.php?catalog=' . $file . '&action='
			. 'remove">Yes</a> / ';
		echo '<a href="index.php">No</a><br /><br />';
		echo '</center>';
		echo '</div>';
	}

	function delete_catalog( $file )
	{
		if( unlink( 'users/' . $_SESSION['ms_username'] . '/' . $file ) )
			header( 'Location: index.php' );
	}

	function main()
	{
		if( isset( $_GET['action'] ) 
			&& $_GET['action'] == 'remove' )
		{
			if( isset( $_GET['catalog'] ) )
				delete_catalog( $_GET['catalog'] );
			else
			{
				create_html_start();
				echo 'You must give catalog name too!<br />';
			}
		}
		else
		{
			create_html_start();

			if( isset( $_GET['catalog'] ) )
				show_confirmation_form( $_GET['catalog'] );
			else
				echo 'There is no catalog name given!<br>';
		}

		echo '<center>';
		echo '<a href="index.php">Back to catalog list</a>';
		echo '</center>';

		create_html_end();
	}

	main();

?>
