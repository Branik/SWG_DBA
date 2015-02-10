SWG_DBA
=======

SnowWolfe Games, LLC Database Abstraction Layer

# regular select
$Columns = [
	[
		'Table'	 => 'go_n', # this is optional if using one table
		'Field'	 => 'Field1'
	],
	[
		'Table'	 => 'go_n',
		'Field'	 => 'Field2'
	],
	[
		'SQLFunction'	 => 'SUBSTRING_INDEX',  # using an sql function
		'Table'			 => 'go_n',
		'Field'			 => 'Field3',
		'FormatLevel'	 => "' ', 10",
		'ReturnAs'		 => 'Field3'
	],
	[
		'Table'		 => 'u_i',
		'Field'		 => 'Field4',
		'ReturnAs'	 => 'NamedTheField'  # using a return as to name the returning value for assoc or object
	]
];
$Where = [
	[
		'FirstOperandTable'	 => 'go_n', # table is optional if the query is run against one table
		'FirstOperand'		 => 'Field6',
		'ExpressionOperator' => '=',
		'SecondOperand'		 => 'Value1'
	],
    [
        'ClauseOperator' => 'AND', # clause operator is needed for every condition after the first
		'FirstOperandTable'	 => 'go_n',
		'FirstOperand'		 => 'Field7',
		'ExpressionOperator' => '=',
		'SecondOperand'		 => 'Value2'
	]
];
$JoinTables = [
	[
		'JoinType'		 => 'LEFT',
		'JoinTable'		 => 'Table2',
		'JoinAlias'		 => 'u_i', # Aliasing tables is optional. If you alias, use alias in columns/where arrays, etc.
		'JoinMethod'	 => 'ON',
		'JoinStatement'	 => '`go_n`.`Field1` = `u_i`.`Field9`' # if you use the ON method to join, you have to do the backticks yourself
	]
];
$OrderBy = [
	[
		'Column'	 => 'Field8',
		'Direction'	 => 'DESC' # direction is optional param. defaults to ascending
	]
];

try {
	$DB_Con->SetTable('tablename', 'go_n') # aliasing is optional
		->SetJoinTables($JoinTables)
		->SetColumns($Columns)
		->SetWhere($Where)
		->SetLimit(3)
		->SetOrderBy($OrderBy); # most of the methods can be chained
	$Result = $DB_Con->Query('SELECT', 'Standard');
	while ($Rows = $DB_Con->FetchResults($Result, "object")) # the options for fetch are array, assoc, and object
	{
        # do stuff
	}
} catch (\InvalidArgumentException $e) {
	# do stuff
} catch (\DBException $e) {
	# do stuff
} catch (\Exception $e) {
	# do stuff
} finally {
  $DB_Con->CloseResult()->ResetQuery(); # be sure you always reset your query or you can get errors with the next query
}


# select prepared
		$Columns = [
			[
				'Field' => 'data'
			]
		];
		$Where = [
			[
				'FirstOperand'		 => 'id',
				'ExpressionOperator' => '=', # SecondOperand is not included in prepared statements
			]
		];
		$Params = [ # unlike the others, this one is just a single array, not multi-dimensional
			$id
		];
		try {
			$DB_Con->SetTable('Table')
				->SetColumns($Columns)
				->SetWhere($Where)
				->SetInputParams($Params)
				->SetLimit(1);
			$Statement = $DB_Con->Query('SELECT', 'Prepared');
			$DB_Con->BindInputParams()
				->ExecutePreparedQuery();
			$Session = $DB_Con->FetchPreparedResults("assoc");
			$DB_Con->CloseStmt();
		} catch (\InvalidArgumentException $e) {
	# do stuff
		} catch (\DBException $e) {
	# do stuff
		} catch (\Exception $e) {
	# do stuff
		} finally {
			$DB_Con->ResetQuery();
		}


# update standard
$Columns = [
	[
		'Field'	 => 'field1',
		'Value'	 => $Val1
	]
];
$Where = [
	[
		'FirstOperand'		 => 'field2',
		'ExpressionOperator' => '=',
		'SecondOperand'		 => $Val2
	]
];

try {
	$DB_Con->SetTable('table')
		->SetColumns($Columns)
		->SetWhere($Where);
	$Result = $DB_Con->Query('UPDATE', 'Standard'); # queries that are not selects return true/false on success/failure
	if ($Result === FALSE)
	{
	# do stuff
	}
} catch (\InvalidArgumentException $e) {
	# do stuff
} catch (\NoResultException $e) {
	# do stuff
} catch (\DBException $e) {
	# do stuff
} catch (\Exception $e) {
	# do stuff
} finally {
	$DB_Con->ResetQuery();
}


# update prepared
		$Columns = [
			[
				'Field' => 'field1'
			]
		];
		$Where = [
			[
				'FirstOperand'		 => 'field2',
				'ExpressionOperator' => '=',
			]
		];
		$Params = [
			$Val1,
			$Val2
		];

		try {
			$DB_Con->SetTable('ferrets')
				->SetColumns($Columns)
				->SetInputParams($Params)
				->SetWhere($Where)
				->SetLimit(1);
			$Statement = $DB_Con->Query('UPDATE', 'Prepared');
			$DB_Con->BindInputParams()
				->ExecutePreparedQuery();
		} catch (\InvalidArgumentException $e) {
	# do stuff
		} catch (\NoResultException $e) {
	# do stuff
		} catch (\DBException $e) {
	# do stuff
		} catch (\Exception $e) {
	# do stuff
		} finally {
			$DB_Con->ResetQuery();
		}


# insert standard
$Columns = [
	[
		'Field' => 'field1'
	]
];
$InsertVals[] = [
	[
		'Value' => $Val1
	]
];

try {
	$DB_Con->SetTable('table')
		->SetColumns($Columns)
		->SetInsertValues($InsertVals);
	$Result = $DB_Con->Query('INSERT', 'Standard');
	if ($Result === FALSE)
	{
	# do stuff
	}
} catch (\InvalidArgumentException $e) {
	# do stuff
} catch (\NoResultException $e) {
	# do stuff
} catch (\DBException $e) {
	# do stuff
} catch (\Exception $e) {
	# do stuff
} finally {
	$DB_Con->ResetQuery();
}


# insert prepared
		$Columns = [
			[
				'Field' => 'id'
			],
			[
				'Field' => 'field2'
			]
		];
		$InsertVals[] = [
			[
				'Value' => $id
			],
			[
				'Value' => $val2
			]
		];
		$DuplicateKey = [
			[
				'Field' => 'field2'
			]
		];
		try {
			$DB_Con->SetTable('table1')
				->SetColumns($Columns)
				->SetInsertValues($InsertVals)
				->SetDuplicateKey($DuplicateKey); # using duplicate key is optional for inserts
			$Statement = $DB_Con->Query('INSERT', 'Prepared');
			$DB_Con->ExecutePreparedQuery();
			$DB_Con->CloseStmt();
		} catch (\InvalidArgumentException $e) {
	# do stuff
		} catch (\DBException $e) {
	# do stuff
		} catch (\Exception $e) {
	# do stuff
		} finally {
			$DB_Con->ResetQuery();
		}


# delete standard
		$Where = [
			[
				'FirstOperand'		 => 'field1',
				'ExpressionOperator' => '=',
				'SecondOperand'		 => $val1
			]
		];

		try {
			$DB_Con->SetTable('table')
				->SetWhere($Where);
			$Result2 = $DB_Con->Query('DELETE', 'Standard');
			if ($Result2 === FALSE)
			{
	# do stuff
			}
		} catch (\InvalidArgumentException $e) {
	# do stuff
		} catch (\NoResultException $e) {
	# do stuff
		} catch (\DBException $e) {
	# do stuff
		} catch (\Exception $e) {
	# do stuff
		} finally {
			$DB_Con->ResetQuery();
		}


# delete prepared
		$Where = [
			[
				'FirstOperand'		 => 'id',
				'ExpressionOperator' => '=',
			]
		];
		$Params = [
			$id
		];
		try {
			$DB_Con->SetTable('Table')
				->SetWhere($Where)
				->SetInputParams($Params)
				->SetLimit(1);
			$Statement = $DB_Con->Query('DELETE', 'Prepared');
			$DB_Con->BindInputParams()
				->ExecutePreparedQuery();
			$DB_Con->CloseStmt();
		} catch (\InvalidArgumentException $e) {
	# do stuff
		} catch (\DBException $e) {
	# do stuff
		} catch (\Exception $e) {
	# do stuff
		} finally {
			$DB_Con->ResetQuery();
		}


# The Join Table Array
$JoinTables = [
	[
		'JoinType'		 => 'LEFT',
		'JoinTable'		 => 'table2',
		'JoinAlias'		 => 'a_g',
		'JoinMethod'	 => 'USING',
		'JoinStatement'	 => '(Field2)' # when you use the USING method, you have to do the parenthesis yourself
	]
];

$JoinTables = [
	[
		'JoinType'		 => 'LEFT',
		'JoinTable'		 => 'Table2',
		'JoinAlias'		 => 'u_i', # Aliasing tables is optional. If you alias, use alias in columns/where arrays, etc
		'JoinMethod'	 => 'ON',
		'JoinStatement'	 => '`go_n`.`Field1` = `u_i`.`Field9`' # if you use the ON method to join, you have to do the backticks yourself
	]
];


# using transactions
$DB_Con->AutoCommit(FALSE);
$DB_Con->StartTrans();

# run your queries

# if they error
$DB_Con->RollbackTrans();

# if they complete with no errors
$DB_Con->CommitTrans();
$DB_Con->AutoCommit(TRUE);


# turning debugging on/off
$DB_Con->SetDebug(TRUE);
$DB_Con->SetDebug(FALSE);
