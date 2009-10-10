<?php

	/*
	Login page. Part of My Stuff -project.
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

	function check_login( $username, $password )
	{
		// Remove dots and / chars.
		$username = preg_replace( '/\./', '', $username );
		$username = preg_replace( '/\//', '', $username );

		$userfile = 'users/' . $username . '.txt';
		
		// No user file - user does not exists.
		if(! file_exists( $userfile ) )
		{
			$_SESSION['msg'] = 'User ' . $username . ' is not registered!';
			return;
		}

		$data = file( $userfile, FILE_IGNORE_NEW_LINES );

		foreach( $data as $line )
		{
			$tmp = explode( '=', $line );

			// Make sure that there is two indexes before
			// we try to read from second index.
			if( count( $tmp ) == 2 )
			{
				// Check password
				if( $tmp[1] == sha1( $password ) )
				{
					$_SESSION['ms_username'] = $username;
					return;
				}
				else
				{
					$_SESSION['msg'] = 'Invalid password.';
					return;
				}
			}

		}

	}

	if( isset( $_POST['ms_username'] )
		&& isset( $_POST['password'] ) )
	{
		check_login( $_POST['ms_username'], $_POST['password'] );
	}

	header( 'Location: index.php' );
?>
