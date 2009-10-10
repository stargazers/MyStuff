<?php

	/*
	My Stuff -project general functions.
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

	/*
		Get catalogue names and returns them in array.
	*/
	function get_catalogs()
	{
		$path = 'users/' . $_SESSION['ms_username'] . '/';

		// If user do not have own folder, try to create it.
		if(! file_exists( $path ) )
		{
			if(! mkdir( $path, 0777 ) )
				echo 'Can\'t create user folder!';

			return array();
		}

		$handle = opendir( $path );
		$ret = array();

		// Find all catalogue file, eg. all .txt files
		while( $file = readdir( $handle ) )
		{
			// Do not add . and .. to files listing.
			if( $file != '.' && $file != '..' )
				$ret[] = $file;
		}

		// Return catalogues sorted.
		asort( $ret );
		return $ret;
	}

	function create_html_start()
	{
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" '
			. '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml" '
			. 'lang="en" xml:lang="en">';

		echo '<head>';
		echo '<title>My stuff</title>';
		echo '<link rel="stylesheet" type="text/css" href="mystuff.css" />';
		echo '<meta http-equiv="Content-Type" content="text/html; '
			. 'charset=utf-8" />';
		echo '</head>';

		echo '<body>';
		echo '<div id="header">';
		echo '<h2>My stuff</h2>';
		echo '</div>';

		echo '<div id="content">';
	}

	function show_login()
	{
		echo '<div id="login">';
		echo '<h3>Login</h3>';
		echo '<form action="login.php" method="post">';

		echo '<table>';

		if( isset( $_SESSION['msg'] ) )
		{
			echo '<tr><td colspan="2">';
			echo $_SESSION['msg'];
			echo '</td></tr>';
			unset( $_SESSION['msg'] );
		}

		echo '<tr>';
		echo '<td>Username</td>';
		echo '<td><input type="text" name="ms_username" /></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td>Password</td>';
		echo '<td><input type="password" name="password" /></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td colspan="2" align="center">';
		echo '<input type="submit" value="Login" />';
		echo '</td>';
		echo '</tr>';
		echo '</table>';

		echo '<br />';
		echo '<a href="register.php">Register</a>';
		echo '</form>';
		echo '</div>';
	}

	function create_html_end()
	{
		echo '</div>';

		echo '<div id="footer">';
		echo 'This code is licensed under AGPL.';
		echo 'Source code is available at ';
		echo '<a href="http://github.com/stargazers/MyStuff/tree/master">';
		echo 'GitHub</a><br />';
		echo 'Author: Aleksi Räsänen ';
		echo '<a href="mailto:aleksi.rasanen@runosydan.net">';
		echo '&lt;aleksi.rasanen@runosydan.net&gt;</a> 2009';
		echo '</div>';
		echo '</body>';
		echo '</html>';
	}

	function show_error_msg()
	{
		if( isset( $_SESSION['errorMsg'] ) )
		{
			echo '<div id="error">';
			echo $_SESSION['errorMsg'];
			echo '</div>';

			unset( $_SESSION['errorMsg'] );
		}
	}
?>
