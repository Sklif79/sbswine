<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
{
	die();
}

$arComponentParameters = Array(
	'PARAMETERS' => array(
		'FILTER_TYPE' => array(
			'NAME' => getMessage('LANDING_CMP_PAR_FILTER_TYPE'),
			'TYPE' => 'STRING'
		),
		'BUTTON_ACTION_LINK' => array(
			'NAME' => getMessage('LANDING_CMP_PAR_BUTTON_ACTION_LINK'),
			'TYPE' => 'STRING'
		),
		'BUTTON_ACTION_TITLE' => array(
			'NAME' => getMessage('LANDING_CMP_PAR_BUTTON_ACTION_TITLE'),
			'TYPE' => 'STRING'
		)
	)
);
