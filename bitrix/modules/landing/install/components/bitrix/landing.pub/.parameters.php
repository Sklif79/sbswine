<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
{
	die();
}

$arComponentParameters = Array(
	'PARAMETERS' => array(
		'HTTP_HOST' => array(
			'NAME' => getMessage('LANDING_CMP_PAR_SERVER_NAME'),
			'TYPE' => 'STRING'
		),
		'PATH' => array(
			'NAME' => getMessage('LANDING_CMP_PAR_PATH'),
			'TYPE' => 'STRING'
		)
	)
);
