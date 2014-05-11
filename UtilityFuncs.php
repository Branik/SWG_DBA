<?php

namespace NS;

function Sanitize($DataType, $Value)
{
	# this function needs a lot of work to be worth a shit,
	# but it is needed for custom pics
	$ReturnValue = NULL;

	switch (\strtolower($DataType)) {
		case 'email':
			if (\is_array($Value))
			{
				$ReturnValue = array();
				foreach ($Value as $key => $val)
				{
					$ReturnValue[$key] = Sanitize('email', $val);
				}
			} else
			{
				$Value = \filter_var($Value, \FILTER_SANITIZE_EMAIL);
				$ReturnValue = \filter_var($Value, \FILTER_VALIDATE_EMAIL);
			}
			break;
		case 'date':
			if (\is_array($Value))
			{
				$ReturnValue = array();
				foreach ($Value as $key => $val)
				{
					$ReturnValue[$key] = Sanitize('date', $val);
				}
			}
			if (date("Y-m-d", \strtotime($Value)) != $Value)
			{
				$ReturnValue = 'Invalid Date';
			} else
			{
				$ReturnValue = $Value;
			}
			break;
		case 'sort':
			if ($Value != 'ASC' &&
				$Value != 'DESC')
			{
				$ReturnValue = \FALSE;
			} else
			{
				$ReturnValue = $Value;
			}
			break;
		case 'int':
			if (\is_array($Value))
			{
				$ReturnValue = array();
				foreach ($Value as $key => $val)
				{
					$ReturnValue[$key] = Sanitize('int', $val);
				}
			} else
			{
				$Value = \filter_var($Value, \FILTER_SANITIZE_NUMBER_INT);
				$ReturnValue = \filter_var($Value, \FILTER_VALIDATE_INT);
			}
			break;
		case 'float':
			if (\is_array($Value))
			{
				$ReturnValue = array();
				foreach ($Value as $key => $val)
				{
					$ReturnValue[$key] = Sanitize('float', $val);
				}
			} else
			{
				$Value = \filter_var($Value, \FILTER_SANITIZE_NUMBER_FLOAT, \FILTER_FLAG_ALLOW_FRACTION | \FILTER_FLAG_ALLOW_THOUSAND);
				$ReturnValue = \filter_var($Value, \FILTER_VALIDATE_FLOAT, \FILTER_FLAG_ALLOW_THOUSAND);
			}
			break;
		case 'boolean':
			//$ReturnValue = \filter_var($Value, \FILTER_VALIDATE_BOOLEAN, \FILTER_NULL_ON_FAILURE);
			if (\is_bool($Value))
			{
				$ReturnValue = $Value;
			} else
			{
				$ReturnValue = \NULL;
			}
			break;
		case 'string':
		default:
			if (\is_array($Value))
			{
				$ReturnValue = array();
				foreach ($Value as $key => $val)
				{
					$ReturnValue[$key] = Sanitize('string', $val);
				}
			} else
			{
				$Value = \strip_tags(trim($Value));
				$ReturnValue = \htmlspecialchars(\filter_var($Value, \FILTER_SANITIZE_STRING, \FILTER_FLAG_NO_ENCODE_QUOTES), \ENT_QUOTES, 'UTF-8');
			}
			break;
	}
	return $ReturnValue;

	# end Sanitize()
}



?>