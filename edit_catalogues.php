<?php

	/*
	Edit catalogue file. Part of My Stuff -project.
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

	function create_catalogue_edit_form()
	{
		echo '<form action="edit_catalogues.php" method="post">';
		echo '<table>';
		echo '<tr>';
		echo '<td>Catalogue name: </td>';
		echo '</td>';
		echo '<td align="center">';
		echo '<input type="text" name="catalog_name">';
		echo '</td>';
		echo '</tr><tr>';
		echo '<td>Fields: </td>';
		echo '</td>';
		echo '<td align="center">';
		echo '<input type="text" name="fields">';
		echo '</td>';
		echo '</tr><tr>';
		echo '<td colspan="2" align="center">';
		echo 'Use , character as a delimiter in fields.';
		echo '</td>';
		echo '</tr><tr>';
		echo '<td colspan="2" align="center">';
		echo '<input type="submit" value="Create catalog" />';
		echo '</td>';
		echo '</tr>';

		echo '</table>';
		echo '</form>';
	}

	function check_post_values()
	{
		if(! isset( $_POST['catalog_name'] ) )
			return false;

		$name = $_POST['catalog_name'];
		$name .= '.txt';
		$fields = $_POST['fields'];

		$path = 'users/' . $_SESSION['ms_username'] . '/';
		$catalogs = get_catalogs();

		// Make sure that catalog does not eists.
		foreach( $catalogs as $tmp )
		{
			if( $tmp == $name )
			{
				echo 'Catalog already exists with this name!';
				return false;
			}
		}

		$fh = @fopen( $path . $name, 'w' );

		if(! $fh )
		{
			echo 'Cannot create catalogue file!';
			return false;
		}

		// Write fields in the first row of catalog.
		$fields = str_replace( ',', '|', $fields );
		fwrite( $fh, $fields . "\n" );
		fclose( $fh );

		return true;
	}

	function main()
	{
		if( check_post_values() )
			header( 'Location: index.php' );

		create_html_start();
		echo '<div id="edit_catalogues">';
		create_catalogue_edit_form();
		echo '</div>';

		echo '<div id="main_links">';
		echo '<a href="index.php">List catalogues</a>';
		echo '<a href="logout.php">Logout</a>';
		echo '</div>';

		create_html_end();
	}

	main();

?>
