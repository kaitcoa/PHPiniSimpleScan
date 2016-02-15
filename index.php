<?php
/**
*
* This script is for testing potentially bad configured PHP.INI file.
* It warns you what is best practice. 
* I wrote it for my own purposes. 
* Version 0.1
* @author Aleksandar Kaitovic 
* @mail coakait990@gmail.com
* @copyright Aleksandar Kaitovic 15.02.2016
*/
if(!is_callable('ini_get') || !is_callable('get_defined_functions')){
	die("Ini_get and get_defined_functions must be enabled");
}
/*** Disabled Functions ***/

	$disabledfunctions = array(
	'php_uname', 'getmyuid', 'getmypid', 'passthru', 'leak',
	 'listen', 'diskfreespace', 'tmpfile', 'link', 'ignore_user_abord',
	  'shell_exec', 'dl', 'set_time_limit', 'exec', 'system', 'highlight_file',
	   'source', 'show_source', 'fpaththru', 'virtual', 'posix_ctermid', 'posix_getcwd',
	    'posix_getegid', 'posix_geteuid', 'posix_getgid', 'posix_getgrgid', 'posix_getgrnam',
	     'posix_getgroups', 'posix_getlogin', 'posix_getpgid', 'posix_getpgrp', 'posix_getpid',
	      'posix', '_getppid', 'posix_getpwnam', 'posix_getpwuid', 'posix_getrlimit', 'posix_getsid',
	       'posix_getuid', 'posix_isatty', 'posix_kill', 'posix_mkfifo', 'posix_setegid', 'posix_seteuid',
	        'posix_setgid', 'posix_setpgid', 'posix_setsid', 'posix_setuid', 'posix_times', 'posix_ttyname',
	         'posix_uname', 'proc_open', 'proc_close', 'proc_get_status', 'proc_nice', 'proc_terminate', 'phpinfo',
	          'pcntl_alarm', 'pcntl_fork', 'pcntl_waitpid', 'pcntl_wait', 'pcntl_wifexited', 'pcntl_signal', 'pcntl_signal_dispatch',
	           'pcntl_get_last_error', 'pcntl_strerror', 'pcntl_sigprocmask', 'pcntl_sigwaitinfo', 'pcntl_sigtimedwait', 'pcntl_exec',
	            'pcntl_getpriority', 'pcntl_setpriority'

	);
	$disabledfunc = explode(',', ini_get('disable_functions'));
	$error = false;
	foreach ($disabledfunctions as $function) {
		if(is_callable($function) && !in_array($function, $disabledfunc)){
			$error = true;
			break;
			}
		}

		if($error == true){
			echo "<b>You should disable some functions.</b> Just edit your php.ini file and add disable_functions= ". implode(", ", $disabledfunctions)."<br/><br/>";
		}else{
			echo "You have already disabled all potentialy malicious functions<br/>";
		}

/*** Preform tests ***/

	if(ini_get('display_errors')){
		echo "<b>isplay_errors</b> is set. You should turn it off.<br/>";
	}

	if(ini_get('expose_php')){
		echo "<b>expose_php</b> is set. You should turn it off.<br/>";
	}

	if(!ini_get('max_file_uploads') || ini_get('max_file_uploads') > 99){
		echo "<b>Somebody can DoS you with uploading a lot of files. You should set your <b>max_file_uploads = 99</b><br/>";
	}else{
		echo "<b>max_file_uploads</b> is set to propper value<br/>";
	}

	if(is_callable('php_sapi_name')){
		if (stristr(php_sapi_name(), 'apache')){
			echo "You are using <b>mod_php</b>. This may reveal sensitive informations.<br/>";
		}
	}else{
		echo "<b>php_sapi_name</b> is not readable so script cannot preform mod_php test.<br/>";
	}

	if(ini_get('open_basedir') == ''){
		echo "<b>Open_basedir</b> is empty. You should set it, especially if you are using mod_php<br/>";
	}

	if(ini_get('register_globals')){
		echo "<b>register_globals are enabled.</b> You should set it to off.<br/>";
	}

	if (ini_get('allow_url_include')) {
		echo "<b>allow_url_include</b> is enabled. You must disable it. <br/>";
	}

	if (ini_get('allow_url_fopen')) {
		echo "<b>allow_url_fopen</b> is enabled. You must disable it. <br/>";
	}

	if(!is_callable('file_exists')){
		if(is_readable('/root') && file_exists('/root')){
			echo "Your root folder is readable. This is very bad idea.";
		}

		if(is_readable('/etc/shadow') && file_exists('/etc/shadow')){
			echo "Your root <b>/etc/shadow</b> file is readable. This is very bad idea.<br/>";
		}
	}else{
		echo "<b>file_exists</b> must be enabled to preform root checking.<br/>";
	}

	if (ini_get('session.use_trans_sid')) {
		echo "<b>session.use_trans_sid</b> is enabled, set it to off. Because it can steal sensitive informations.";
	}

	if (!ini_get('session.use_only_cookies')) {
		echo "<b>session.use_only_cookies</b> is disabled. Set ti ON.<br/>";
	}

	if(!ini_get('session.cookie_httponly')){
		echo "<b>Session.cookie_httponly</b> is disabled. For security reasons you should turn it ON! <br/>";
	}

	if(!ini_get('session.cookie_secure')){
		echo "<b>session.cookie_secure</b> is disabled. For security reasons you should turn it ON! <br/>";
	}
	if(!ini_get('session.hash_function')){
		echo "<b>session.hash_function</b> is disabled. For security reasons you should turn it ON! <br/>";
	}

	if(!ini_get('safe_mode')){
		echo "<b>safe_mode</b> is off. You need to set it ON.<br/>";
	}
	if(!ini_get('report_memleaks')){
		echo "<b>report_memleaks</b> is off. You need to set it ON.<br/>";
	}	

	if(ini_get('track_errors')){
		echo "<b>track_errors</b> is off. You should to set it off.<br/>";
	}

	if(ini_get('html_errors')){
		echo "<b>html_errors</b> is off. You should to set it off.<br/>";
	}


?> 
