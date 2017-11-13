<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('QTDE_CARACTERES_FREE', 1200);

define('NO_REDIRECT' , false);
define('REDIRECT' , true);

define('STATUS_AGUARDANDO_PAGAMENTO', 'AGUARDANDO_PAGAMENTO');
define('STATUS_AGUARDANDO_PAGSEGURO', 'AGUARDANDO_PAGSEGURO');
define('STATUS_PAGO', 'PAGO');

define('PAGSEGURO_ID_STATUS_PAGO', 3);

define('NOME_SISTEMA', 'Taromancia');
define('VERSAO_SISTEMA', 'v1.0.0');

define('PEDIDOS_PREFIXO_REFERENCIA', 'PED');
define('PEDIDOS_PADDING_LENGTH', 6);

define('PAGSEGURO_EMAIL_PRODUCAO', 'financeiro@taromancia.com.br');
define('PAGSEGURO_TOKEN_PRODUCAO', 'A7496A83A92448169E9923D64A34B52E');

define('PAGSEGURO_EMAIL_SANDBOX', 'tiagozn@gmail.com');
define('PAGSEGURO_TOKEN_SANDBOX', 'DA411D213040408C8F632F29931571BF');

// define('ENVIROMENT_PAGSEGURO', 'production');
define('ENVIROMENT_PAGSEGURO', 'sandbox');

/* End of file constants.php */
/* Location: ./application/config/constants.php */