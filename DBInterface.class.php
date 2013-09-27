<?php
# DBInterface.class.php
# by Nicole Ward
# <http://snowwolfegames.com>
# <nikki@snowwolfegames.com>
#
# Copyright © 2009 - 2013 - SnowWolfe Games, LLC

# This file is part of DatabaseAbstractionLayer.
# This script sets the interface for the DB controls

#
# methods:
# __construct()
# __clone()
# __destruct()
# -- calls:
# 		- self::Close()
# SetDebugging()
# - Sets the $Debug variable
# -- parameters:
# -- $Debug
# 		- boolean
# 		- sets debug on (TRUE) or off (FALSE)
# -- calls:
# 		- Sanitize()
# SetTable()
# - sets the table for a query
# -- paramaters:
# -- $Table
# 		- string
# 		- table's name
# -- $Alias
# 		- string
# 		- alias for table, optional
# -- calls:
# 		- MySQL_Query::SetTable()
# SetJoinTables()
# - sets the join table(s) for a query
# -- paramaters:
# -- $JoinTables
# 		- array
# 		- names, join methods, join types, join statements
# -- calls:
# 		- MySQL_Query::SetJoinTable()
# SetLockTables()
# - sets the tables to be locked
# -- paramaters:
# -- $LockTables
# 		- array
# 		- names of tables to lock
# -- calls:
# 		- MySQL_Query::SetLockTables()
# SetColumns()
# -sets the column(s) to be used for a query
# -- paramaters:
# -- $Columns
# 		- array
# 		- names of columns to be used
# -- calls:
# 		- MySQL_Query::SetColumns()
# SetWhere()
# - sets the arguments to be used in a where clause
# -- paramaters:
# -- $LockTables
# 		- array
# 		- arguments to build a where clause;
# 		- clause operator, first operand, expression operator, second operand
# -- calls:
# 		- MySQL_Query::SetWhere()
# SetOrderBy()
# - sets the column to order a query by
# -- paramaters:
# -- $OrderBy
# 		- string
# 		- name of column to order by
# -- $Direction
# 		- string
# 		- direction to sort, optional
# -- calls:
# 		- MySQL_Query::SetOrderBy()
# SetGroupBy()
# - sets the column to group a query by
# -- paramaters:
# -- $GroupBy
# 		- string
# 		- name of column to group by
# -- calls:
# 		- MySQL_Query::SetGroupBy()
# SetLimit()
# - sets the limit for a query
# -- paramaters:
# -- $Limit
# 		- integer
# 		- number of rows to return
# -- $Offset
# 		- integer
# 		- row to start on, optional
# -- calls:
# 		- MySQL_Query::SetLimit()
# SetInsertValues()
# - sets the values for an insert query
# -- paramaters:
# -- $Values
# 		- array
# 		- values for each column in an insert query
# -- calls:
# 		- MySQL_Query::SetInsertValues()
# SetDuplicateKey()
# - sets the columns to be updated on duplicate key
# -- paramaters:
# -- $DuplicateKey
# 		- array
# 		- columns to update on duplicate key
# -- calls:
# 		- MySQL_Query::SetDuplicateKey()
# SetEngine()
# - sets the engine to be used when creating a (temporary) table
# -- paramaters:
# -- $Engine
# 		- string
# 		- engine to use
# -- calls:
# 		- MySQL_Query::SetEngine()
# GetParamType()
# - determines the type of a paramater
# -- paramaters:
# -- $Value
# 		- string
# 		- paramater to be examined
# -- returns:
# 		- type of submitted value
# StartDebugging()
# - opens the debugging log up for use
# -- calls:
# 		- Logger::init()
# 		- Logger::OpenLogFile()
# Connect()
# - connects to mysql using mysqli to the main game db
# -- paramaters:
# -- calls:
# -- returns:
# GetDBInstance()
# - gets an instance of this class for other code
# -- calls:
# 		- self::construct()

# select_db() - changes db
# -- parameters:
# -- $DB
#			- string
#			- name of the desired database to connect to
# connected()
# - checks that there is a connection to mysql
# HandleError()
# - handles triggering error logging
# -- parameters:
# -- $error
# close()
# - closes the connection
# PreparedStmtQuery()
# - queries any table(s), any number of fields, any where arguments
# -- parameters:
# -- $QueryArr
# -- calls:
# -- self::PrepareQuery()
# PreparedStmtUpdate()
# - updates any table, any number of fields, any where arguments
# -- parameters:
# -- $QueryArr
# -- calls:
# -- self::PrepareQuery()
# PreparedStmtDelete()
# - deletes from any table, any where arguments
# -- parameters:
# -- $QueryArr
# -- calls:
# -- self::PrepareQuery()
# PreparedStmtInsert()
# - inserts into any table, any number of fields/values
# -- parameters:
# -- $QueryArr
# -- calls:
# -- self::PrepareQuery()
# RegularQuery()
# - queries any table(s), any number of fields, any where arguments
# -- parameters:
# -- $QueryArr
# RegularUpdate()
# - updates any table, any number of fields, any where arguments
# -- parameters:
# -- $QueryArr
# -- calls:
# -- self::RunQuery()
# -- self::HandleError()
# RegularDelete()
# - deletes from any table, any where arguments
# -- parameters:
# -- $QueryArr
# -- calls:
# -- self::RunQuery()
# -- self::HandleError()
# RegularInsert()
# - inserts into any table, can do insert/select
# -- parameters:
# -- $QueryArr
# -- calls:
# -- self::RunQuery()
# -- self::HandleError()
# TruncateTable()
# - truncates a table
# -- parameters:
# -- $QueryArr
# -- calls:
# -- self::RunQuery()
# -- self::HandleError()
# OptimizeTable()
# - optimizes a table
# -- parameters:
# -- $QueryArr
# -- calls:
# -- self::RunQuery()
# -- self::HandleError()
# ShowTables
# - gets a list of the tables in the database
# PrepareQuery()
# - prepares a prepared statement query
# -- calls:
# -- self::HandleError()
# BindInputParams()
# - binds the input parameters for a prepared statement query
# -- parameters:
# -- $QueryObj
# -- calls:
# -- self::HandleError()
# ExecutePreparedQuery()
# - executes prepared statement query and if needed stores the result
# -- calls:
# -- self::HandleError()
# FetchPreparedResults()
# -- parameters:
# -- $ReturnFormat
# -- calls:
# -- self::HandleError()
# CloseStmt()
# RunQuery()
# - executes queries
# -- calls:
# -- self::HandleError()
# FetchResults()
# -- parameters:
# -- $ResultResource
# -- $ReturnFormat
# -- calls:
# -- self::HandleError()
# CloseResult()
# -- parameters:
# -- $ResultResource
# num_rows()
# -- parameters:
# -- $ResultResource
# affected_rows()

if (0 > version_compare(PHP_VERSION, '5'))
	{
		throw new Exception('This file was generated for PHP 5');
	}

require_once('interface.DBInterface.php');

/* user defined includes */

/* user defined constants */


interface DBInterface
	{
		public function __construct();

		public function __clone();

		public function __destruct();

		public function SetDebug($Debug);

		public function SetTable($Table, $Alias = NULL);

		public function SetJoinTables(Array $Tables);

		public function SetLockTables(Array $LockTables);

		public function SetColumns(Array $Columns);

		public function SetWhere(Array $Where);

		public function SetOrderBy($OrderBy, $Direction = NULL);

		public function SetGroupBy($GroupBy);

		public function SetLimit($Limit, $Offset = NULL);

		public function SetInsertValues(Array $Values);

		public function SetDuplicateKey($DuplicateKey);

		public function SetEngine($Engine);

		public function GetParamType($Value);

		public function StartDebugging();

		public function Connect($Database);

		public function Connected();

		public function Close();

		public function SelectDB($Database);

		public function ErrorNo();

		public function Error();

		public function EscapeString($String);

		public function InsertID();

		public function AutoCommit($Setting);

		public function StartTrans();

		public function RollbackTrans();

		public function CommitTrans();

		public function PrepareQuery();

		public function BindInputParams();

		public function ExecutePreparedQuery();

		public function FetchPreparedResults($ReturnFormat = 'assoc');

		public function StmtBindArray(&$ReturnArr);

		public function StmtBindAssoc(&$ReturnArr);

		public function StmtBindObject(&$ReturnObj);

		public function CloseStmt();

		public function RunQuery();

		public function FetchResults($ReturnFormat = 'assoc', $ReturnArrFormat = 'MYSQLI_NUM');

		public function CloseResult();

		public function NumRows();

		public function AffectedRows();

		public function Query($QueryType = NULL, $RunAs = 'Standard');

		public function ShowTables();
	} # end of interface DBInterface
?>