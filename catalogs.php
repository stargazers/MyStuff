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

	function create_list( $catalog )
	{
		$path = 'users/' . $_SESSION['ms_username'] . '/';

		// Read file without line breaks.
		$data = file( $path . $catalog, FILE_IGNORE_NEW_LINES );

		// There MUST be always fields list at least in file!
		if(! isset( $data[0] ) )
			return false;

		// Remove the line where is fields names. Then sort the array
		// and after sort put those field names back to an array.
		$field_names = array_shift( $data );
		asort( $data );
		array_unshift( $data, $field_names );

		// Get fields in to array and get number of fields total.
		$fields = explode( '|', $data[0] );
		$num_fields = count( $fields );
		$row_count = 0;

		echo '<div id="list">';
		echo '<form action="catalogs.php?catalog=' . $catalog 
			.  '" method="post">';

		// If there is only one field, we should use
		// different CSS style, so the table will be more centered.
		if( $num_fields == 1 )
			echo '<table id="list_table_1">';
		else
			echo '<table id="list_table_2">';
		
		// Add every found row in the list.
		foreach( $data as $row )
		{
			$tmp = explode( '|', $row );

			echo '<tr>';

			for( $i=0; $i < $num_fields; $i++ )
			{
				echo '<td>';

				if( $row_count == 0 )
				{
					echo '<b>' . $tmp[$i] . '</b>';
				}
				else
				{
					echo '<input type="text" name="field[' 
						. $row_count . '][' . $i . ']" value="'
						. $tmp[$i] . '">';
				}
				echo '</td>';
			}
			echo '</tr>';

			$row_count++;
		}

		echo '<tr>';
		for( $i=0; $i < $num_fields; $i++ )
		{
			echo '<td>';
			echo '<input id="new_item" type="text" name="field[' 
				. $row_count . '][' . $i . ']">';
			echo '</td>';
		}
		echo '</tr>';

		echo '<tr>';
		echo '<td align="center" colspan="' . $num_fields . '">';
		echo  'Total: ' . ( $row_count -1 ). '<br />';
		echo '<input type="submit" value="Save">';
		echo '</td>';
		echo '</tr>';

		echo '</table>';
		echo '</form>';
		echo '</div>';
	}

	function check_post_values()
	{
		if(! isset( $_POST['field'] ) )
			return false;

		if(! isset( $_GET['catalog'] ) )
			return false;

		$path = 'users/' . $_SESSION['ms_username'] . '/';
		
		// Read old values so we can easily get how
		// many columns there is in that file.
		$data = file( $path . $_GET['catalog'], FILE_IGNORE_NEW_LINES );
		$fields = explode( '|', $data[0] );
		$num_fields = count( $fields );

		// Open catalog for writing and write headers.
		$fh = @fopen( $path . $_GET['catalog'], 'w' );
		fwrite( $fh, $data[0] . "\n" );

		// Write all POST-data to file.
		foreach( $_POST['field'] as $tmp )
		{ 
			$num_empty = 0;

			// Count how many empty fields we have in this row
			for( $i=0; $i<$num_fields; $i++ )
			{
				if( $tmp[$i] == '' )
					$num_empty++;
			}

			// We do not want add empty rows to file.
			if( $num_empty == $num_fields )
				continue;

			for( $i=0; $i < $num_fields; $i++ )
			{
				fwrite( $fh, $tmp[$i] );

				if( $i != $num_fields-1 )
					fwrite( $fh, '|' );
			}

			fwrite( $fh, "\n" );
		}

		fclose( $fh );

		echo '<center>';
		echo 'Catalog updated!';
		echo '</center><br />';
		return true;
	}

	function main()
	{
		create_html_start();
		check_post_values();

		$path = 'users/' . $_SESSION['ms_username'] . '/';

		if(! isset( $_GET['catalog'] ) )
		{
			echo 'You must give catalog name!';
		}
		else
		{
			// Catalog file not found!
			if(! file_exists( $path . $_GET['catalog̈́'] ) )
				echo 'You don\'t have catalogue with that name!';
			else
				create_list( $_GET['catalog'] );

			echo '<center>';
			echo '<br />';
			echo '<a href="index.php">Back to main page</a>';
			echo '</center><br />';
			create_html_end();
		}
	}

	main();
?>
