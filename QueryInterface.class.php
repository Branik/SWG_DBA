<?php
# QueryInterface.class.php
# by Nicole Ward
# <http://snowwolfegames.com>
# <nikki@snowwolfegames.com>
#
# Copyright © 2009 - 2013 - SnowWolfe Games, LLC

# This file is part of DatabaseAbstractionLayer.
# This script handles mysql database interactions.

# methods:
# __construct()
# -- parameters:
# -- $DB_Con
# 		- resource
# 		- holds the database connection handle
# __clone()
# __destruct()
# - calls:
# - Logger::CloseLogFile()
# StartDebugging()
# - opens the debugging log up for use
# - calls:
# - Logger::init()
# - Logger::OpenLogFile()
# ResetQuery()
# - Resets all the variables for making a query
# SetDebugging()
# - Sets the $Debug variable
# -- parameters:
# -- $Debug
# 		- boolean
# 		- sets debug on (TRUE) or off (FALSE)
# - calls:
# - Sanitize()
# SetQuery()
# - Sets the $SQL variable
# -- parameters:
# -- $QueryType
# 		- string
# 		- holds the type of query to be created
# SetTable()
# - Sets the $Table variable
# -- parameters:
# -- $Table
# 		- string
# 		- holds the name of the table the query will be performed against
# -- $Alias
# 		- string
# 		- holds the alias to use for the table in the query
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetJoinTables()
# - Sets the $JoinTable, $JoinType, $JoinMethod, $JoinStatement variables
# -- parameters:
# -- $JoinTable
# 		- string
# 		- holds the name of tables for creating a join query
# -- $JoinType
# 		- string
# 		- holds the join type for a join query
# -- $JoinMethod
# 		- string
# 		- holds the way the tables will be joined
# -- $JoinStatement
# 		- string
# 		- holds the statement for joining the tables
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetLockTables()
# - Sets the $LockTables variable
# -- parameters:
# -- $LockTables
# 		- array
# 		- holds the names of the tables to be locked
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetColums()
# - Sets the $SelectColumns variable
# -- parameters:
# -- $Columns
# 		- array
# 		- holds the names of the columns to be selected
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetWhere()
# - Sets the $Where variable
# -- parameters:
# -- $Where
# 		- array
# 		- holds the information for creating a where clause
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetOrderBy()
# - Sets the $OrderBy variable
# -- parameters:
# -- $OrderBy
# 		- array
# 		- holds the order by field
# -- $Direction
# 		- array
# 		- holds the order by direction
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetGroupBy()
# - Sets the $GroupBy variable
# -- parameters:
# -- $GroupBy
# 		- string
# 		- holds the field to group by
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetLimit()
# - Sets the $Limit variable
# -- parameters:
# -- $Limit
# 		- integer
# 		- holds the limit number
# -- $Offset
# 		- integer
# 		- holds the offset number
# 		- defaults to null
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetInsertValues()
# - Sets the $InsertValues variable
# -- parameters:
# -- $Values
# 		- array
# 		- holds the values for an insert query
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetDuplicateKey()
# - Sets the $GroupBy variable
# -- parameters:
# -- $DuplicateKey
# 		- array
# 		- holds the field to update on duplicate key
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# SetEnginey()
# - Sets the $Engine variable
# -- parameters:
# -- $Engine
# 		- string
# 		- holds the engine to use
# - calls:
# - Sanitize()
# - Logger::WriteToLog
# GetSQL()
# - returns:
# - the $SQL variable
# BuildSelectQuery()
# - calls:
# - self::BuildSelectClause()
# - self::BuildTableClause()
# - self::BuildJoinClause()
# - self::BuildWhereCluase()
# - self::BuildOrderByClause()
# - self::BuildLimitClause()
# - Logger::WriteToLog
# BuildUpdateQuery()
# - calls:
# - self::BuildTableClause()
# - self::BuildUpdateClause()
# - self::BuildWhereClause()
# - self::BuildLimitClause()
# - Logger::WriteToLog
# BuildInsertQuery()
# - calls:
# - self::BuildTableClause()
# - self::BuildInsertClause()
# - self::BuildDuplicateKeyClause()
# - Logger::WriteToLog
# BuildDeleteQuery()
# - calls:
# - self::BuildDeleteClause()
# - self::BuildTableClause()
# - self::BuildJoinClause()
# - self::BuildWhereClause()
# - self::BuildLimitClause()
# - Logger::WriteToLog
# BuildAlterQuery()
# - calls:
# - self::BuildTableClause()
# - self::BuildAlterClause()
# - Logger::WriteToLog
# BuildTruncateQuery()
# - calls:
# - self::BuildTableClause()
# - Logger::WriteToLog
# BuildOptimizeQuery()
# calls:
# - Logger::WriteToLog
# BuildShowColumnQuery()
# - calls:
# - Logger::WriteToLog
# BuildShowTablesQuery()
# - calls:
# - Logger::WriteToLog
# BuildCreateTemporaryQuery()
# - calls:
# - self::BuildTableQuery()
# - self::BuildCreateTemporary()
# - self::BuildEngineClause()
# - Logger::WriteToLog
# BuildDropTemporaryQuery()
# - calls:
# - self::BuildTableClause()
# - Logger::WriteToLog
# BuildLockTablesQuery()
# - calls:
# - self::BuildLockTablesClause()
# - Logger::WriteToLog
# BuildUnlockTablesQuery()
# - calls:
# - Logger::WriteToLog
# BuildSelectClause()
# - calls:
# - Logger::WriteToLog
# BuildUpdateClause()
# - calls:
# - MySQL_DB::EscapeString()
# - Logger::WriteToLog
# BuildInsertClause()
# - calls:
# - Logger::WriteToLog
# BuildOnDuplicateKeyClause()
# - calls:
# - Logger::WriteToLog
# BuildDeleteClause()
# - calls:
# - Logger::WriteToLog
# BuildAlterClause()
# - calls:
# - Logger::WriteToLog
# BuildCreateTemporaryClause()
# - calls:
# - Logger::WriteToLog
# BuildTableClause()
# - calls:
# - Logger::WriteToLog
# BuildJoinClause()
# - calls:
# - Logger::WriteToLog
# BuildWhereClause()
# - calls:
# - Logger::WriteToLog
# BuildOrderByClause()
# - calls:
# - Logger::WriteToLog
# BuildLimitClause()
# - calls:
# - Logger::WriteToLog
# BuildLockTablesClause()
# - calls:
# - Logger::WriteToLog
# BuildEngineClause()
# - calls:
# - Logger::WriteToLog

if (0 > version_compare(PHP_VERSION, '5'))
	{
		throw new Exception('This file was generated for PHP 5');
	}

interface QueryInterface
	{
		public function __construct(MySQL_DB $DB_Con);

		public function __clone();

		public function __destruct();
		
		public function StartDebugging();
		
    public function ResetQuery();
		
		public function SetQuery();

		public function SetTable($Table, $Alias = NULL);

		public function SetJoinTable($JoinType, $JoinTable, $JoinMethod, $JoinStatement);

		public function SetColumns(Array $Columns);

		public function SetWhere(Array $Where);

		public function SetOrderBy($OrderBy, $Direction = NULL);

		public function SetGroupBy($GroupBy);

		public function SetLimit($Limit, $Offset = NULL);

		public function GetSQL();

		public function BuildSelectQuery();

		public function BuildUpdateQuery();

		public function BuildInsertQuery();

		public function BuildDeleteQuery();

		public function BuildAlterQuery();

		public function BuildTruncateQuery();

		public function BuildOptimizeQuery();

		public function BuildShowColumnsQuery();

		public function BuildShowTablesQuery();

		public function BuildCreateTemporaryQuery();

		public function BuildDropTemporaryQuery();

		public function BuildLockTablesQuery();

		public function BuildUnlockTablesQuery();

		private function BuildSelectClause();

		private function BuildUpdateClause();

		private function BuildInsertClause();

		private function BuildOnDuplicateKeyClause();

		private function BuildDeleteClause();

		public function BuildAlterClause();

		public function BuildCreateTemporaryClause();

		private function BuildTableClause($QueryType);

		private function BuildJoinClause();

		private function BuildWhereClause();

		private function BuildOrderByClause();

		private function BuildLimitClause();

		public function BuildLockTablesClause();

		public function BuildEngineClause();

	} # end QueryInterface interface
?>