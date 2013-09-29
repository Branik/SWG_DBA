<?php
# MySQL_DB.class.php
# by Nicole Ward
# <http://snowwolfegames.com>
# <nikki@snowwolfegames.com>
#
# Copyright (c) 2009 - Nicole Ward


# This file is part of DatabaseAbstractionLayer.
# This script handles mysql database interactions.

# properties:
# $DB_Con
# - protected
# - resource
# - holds the connection handle to the db
# $Debug
# - protected
# - boolean
# - flag if debugging is on/off
# $Table
# - protected
# - string
# - holds the name of the current table
# $SelectColumns
# - protected
# - array
# - holds the column names for a select query
# $JoinTables
# - protected
# - array
# - holds the tables for join queries
# $Select = null;
# $Where
# - protected
# - string
# - holds the where information
# $OrderBy
# - protected
# - string
# - holds order by information
# $GroupBy
# - protected
# - string
# - holds group by information
# $Limit
# - protected
# - integer
# - holds limit number
# $Offset
# - protected
# - integer
# - holds offset number
# $SelectClause
# - protected
# - string
# - holds the select portion of a query
# $TableClause
# - protected
# - string
# - holds the table portion of a query
# $WhereClause
# - protected
# - string
# - holds the where portion of a query
# $OrderByClause
# - protected
# - string
# - holds the order by portion of a query
# $GroupByClause
# - protected
# - resource
# - holds the group by portion of a query
# $LimitClause
# - protected
# - resource
# - holds the limit portion of a query
# $AutoCommit
# - protected
# - resource
# - holds the connection handle to the db
# $SQL
# - protected
# - string
# - holds the complete sql query
# $Result
# - protected
# - resource
# - holds result resource
# $SQLStmt
# - protected
# - resource
# - holds the prepared statement resource

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

/**
 * include DBInterface
 *
 * @author Nicole Ward, <nikki@snowwolfegames.com>
 */
require_once('interface.DBInterface.php');

/* user defined includes */

/* user defined constants */


final class MySQL_DB
			implements DBInterface
	{

		protected $DB_Con = NULL;
		protected $Debug = FALSE;
		protected $Debugging = NULL;
		protected $QueryObj = NULL;
		protected $AutoCommit = NULL;
		protected $SQL = NULL;
		protected $CurrentResult = NULL;
		protected $SQLStmt = NULL;
		protected $InputParams = NULL;
		protected $InputBindParams = NULL;


		public function __construct()
			{

			} # end __construct()


		public function __clone()
			{
				trigger_error('Clone is not allowed.', E_USER_ERROR);
			} # end clone()


		public function __destruct()
			{
				$this->Close();
			} # end __destruct()


		public function SetDebug($Debug)
			{
				$this->Debug = Sanitize('boolean', $Debug);

				if ($this->Debug == TRUE)
					{
						$this->StartDebugging();
					}
			} # end SetDebug()


		public function SetTable($Table, $Alias = NULL)
			{
				$this->QueryObj->SetTable($Table, $Alias);
			} # end SetTable()


		public function SetJoinTables(Array $Tables)
			{
				$this->JoinTables = $Tables;
			} # end SetJoinTables()


		public function SetLockTables(Array $LockTables)
			{
				$this->QueryObj->SetLockTables($LockTables);
			} # end SetLockTables()


		public function SetColumns(Array $Columns)
			{
				$this->QueryObj->SetColumns($Columns);
			} # end SetColumns()


		public function SetWhere(Array $Where)
			{
				$this->QueryObj->SetWhere($Where);
			} # end SetWhere()


		public function SetOrderBy($OrderBy, $Direction = NULL)
			{
				$this->QueryObj->SetOrderBy($OrderBy, $Direction);
			} # end SetOrderBy


		public function SetGroupBy($GroupBy)
			{
				$this->QueryObj->SetGroupBy($GroupBy);
			} # end SetGroupBy


		public function SetLimit($Limit, $Offset = NULL)
			{
				$this->QueryObj->SetLimit($Limit, $Offset);
			} # end SetLimit()


		public function SetInsertValues(Array $Values)
			{
				$this->QueryObj->SetInsertValues($Values);
			} # end SetInsertValues()


		public function SetDuplicateKey($DuplicateKey)
			{
				$this->QueryObj->SetDuplicateKey($DuplicateKey);
			} # end SetDuplicateKey()


		public function SetEngine($Engine)
			{
				$this->QueryObj->SetEngine($Engine);
			} # end SetEngine()


		public function GetParamType($Value)
			{
				# get the value's type
				$ValueType = gettype($Value);

				# assign it a prepared statement type
				switch ($ValueType) {
					case 'integer':
						$ReturnValue = 'i';
						break;
					case 'double':
						$ReturnValue = 'd';
						break;
					case 'string':
						$ReturnValue = 's';
						break;
					default:
						$ReturnValue = FALSE;
						break;
				}

				return $ReturnValue;
			} # end GetParamType


		public function StartDebugging()
			{
				$this->Debugging = new Logger();
				$this->Debugging->init($FileName, $IncludeDate = TRUE, $Priority = 'Medium', $LogType = 'Debugging', $Sendmail = FALSE);
				$this->Debugging->OpenLogFile();
			} # end StartDebugging()


		public function Connect($Database)
			{
				# get our database connection
				$this->DB_Con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

				# check connection
				if (mysqli_connect_errno())
					{
						throw new DBException('Connect failed.');
					}

				$this->DB_Con->query("SET NAMES 'utf8'");

				# get our query object
				$this->QueryObj = new Mysql_Query($this->DB_Con);
				if ($this->Debug == TRUE)
					{
						$this->QueryObj->SetDebug(TRUE);

						$LogData = __FILE__.' '.__METHOD__.' Connected.';
						$this->Debugging->WriteToLog($LogData);
					}

				return $this->DB_Con;
			} # end Connect()


		public function Connected()
			{
				$returnValue = null;
				if ($this->DB_Con)
					{
						$returnValue = ($this->DB_Con->ping() == TRUE) ? TRUE : FALSE;
					} else {
						$returnValue = FALSE;
					}
				return $returnValue;
			} # end Connected


		public function Close()
			{
				if ($this->DB_Con)
					{
						$this->DB_Con = NULL;
					}
				if ($this->QueryObj)
					{
						$this->QueryObj = NULL;
					}
			} # end Close()


		public function SelectDB($Database)
			{
				$returnValue = null;
				$returnValue = $this->DB_Con->select_db($Database);

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Select DB: '.$Database;
						$LogData .= (!empty($returnValue)) ? 'DB selected.' : 'Select DB failed.';
						$this->Debugging->WriteToLog($LogData);
					}

				if ($returnValue == FALSE)
					{
						throw new DBException('Unable to select database.');
					}

				return $returnValue;
			} # end SelectDB()


		public function ErrorNo()
			{
				$returnValue = $this->DB_Con->errno;

				return $returnValue;
			} # end ErrorNo()


		public function Error()
			{
				$returnValue = $this->DB_Con->error;

				return $returnValue;
			} # end Error()


		private function EscapeString($String)
			{
				$returnValue = null;
				$returnValue = $this->DB_Con->real_escape_string($String);
				return $returnValue;
			} # end EscapeString()


		public function InsertID()
			{
				$returnValue = $this->DB_Con->insert_id;

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__;
						$this->Debugging->WriteToLog($LogData);
					}

				return $returnValue;
			} # end InsertID()


		public function AutoCommit($Setting)
			{
				$this->DB_Con->autocommit($Setting);

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Setting: '.$Setting;
						$this->Debugging->WriteToLog($LogData);
					}

			} # end AutoCommit()


		public function StartTrans()
			{

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Table: '.$this->Table;
						$this->Debugging->WriteToLog($LogData);
					}

			} # end StartTrans()


		public function RollbackTrans()
			{
				$returnValue = $this->DB_Con->rollback();

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__;
						$this->Debugging->WriteToLog($LogData);
					}

				if ($returnValue == FALSE)
					{
						throw new DBException('Rollback failed.');
					}

				return $returnValue;
			} # end RollbackTrans()


		public function CommitTrans()
			{
				$returnValue = $this->DB_Con->commit();

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__;
						$this->Debugging->WriteToLog($LogData);
					}

				if ($returnValue == FALSE)
					{
						throw new DBException('Commit failed.');
					}

				return $returnValue;
			} # end CommitTrans()


		private function PrepareQuery()
			{
				$returnValue = null;
				if (empty($this->SQL))
					{
						return FALSE;
					}

				$this->SQLStmt = $this->DB_Con->prepare($this->SQL);
				$returnValue = (!empty($this->SQLStmt)) ? TRUE : FALSE;

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Prepare query: ';
						$LogData .= (!empty($this->SQLStmt)) ? 'Statement prepared.' : 'Prepare statement failed.';
						$this->Debugging->WriteToLog($LogData);
					}

				if ($returnValue == FALSE)
					{
						throw new DBException('Prepare query failed.');
					}

				return $returnValue;
			} # end PrepareQuery()


		public function BindInputParams()
			{
				$returnValue = null;
				if (empty($this->InputParams) ||
						empty($this->SQLstmt) ||
						empty($this->SQL))
					{
						return FALSE;
					}

				# bind input params requires arguments as references
				# and it is enforced as of php 5.3 soooo
				$this->InputBindParams = array();
				foreach ($this->InputParams as $k => &$arg)
					{
						$this->InputBindParams[$k] = &$arg;
					}

				if (call_user_func_array(array(&$this->SQLstmt, 'mysqli_stmt::bind_param'), $this->InputBindParams))
					{
						$returnValue = TRUE;
					} else {
						throw new DBException('Bind input params failed.');
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Input params: '.var_export($this->InputParams, true);
						$this->Debugging->WriteToLog($LogData);
					}

				return $returnValue;
			} # end BindInputParams()


		public function ExecutePreparedQuery()
			{
				$returnValue = null;
				if (!$this->SQLstmt->execute())
					{
						throw new DBException('Execute prepared query failed.');
					}

				# if this is a select query we need to call store_result
				if (stripos($this->SQL, 'SELECT') !== FALSE)
					{
						if (!$this->SQLstmt->store_result())
							{
								throw new DBException('Store result failed.');
							}
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog($LogData);
					}

				return $returnValue;
			} # end ExecutePreparedQuery()


		public function FetchPreparedResults($ReturnFormat = 'assoc')
			{
				if ($this->SQLstmt->num_rows() > 0)
					{
						switch ($ReturnFormat) {
							case 'assoc':
								$Result = array();
								if ($this->StmtBindAssoc($Result))
									{
										if ($this->SQLstmt->fetch())
											return $Result;
									} else {
								if ($this->Debug == TRUE)
									{
										$LogData = __FILE__.' '.__METHOD__.' Bind input params failed:'.var_export($this->BindParams, true);
										$this->Debugging->WriteToLog($LogData);
									}

										throw new DBException('Fetch prepared results (assoc) failed.');
									}
								break;
							case 'object':
								$Result = new stdClass();
								if ($this->StmtBindObject($Result))
									{
										if ($this->SQLstmt->fetch())
											return $Result;
									} else {
								if ($this->Debug == TRUE)
									{
										$LogData = __FILE__.' '.__METHOD__.' Bind input params failed:'.var_export($this->BindParams, true);
										$this->Debugging->WriteToLog($LogData);
									}

										throw new DBException('Fetch prepared results (object) failed.');
									}
								break;
							case 'array':
							default:
								$Result = array();
								if ($this->StmtBindArray($Result))
									{
										if ($this->SQLstmt->fetch())
											return $Result;
									} else {
								if ($this->Debug == TRUE)
									{
										$LogData = __FILE__.' '.__METHOD__.' Bind input params failed:'.var_export($this->BindParams, true);
										$this->Debugging->WriteToLog($LogData);
									}

										throw new DBException('Fetch prepared results (arrau) failed.');
									}
								break;
							}
					} else {
						return FALSE;
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__;
						$this->Debugging->WriteToLog($LogData);
					}

			} # end FetchPreparedResults()


		public function StmtBindArray(&$ReturnArr)
			{
				$ResultMeta = $this->SQLstmt->result_metadata();
				if ($ResultMeta == FALSE)
					{
						return FALSE;
					}
				$FieldNames = array();
				$ReturnArr = array();
				$FieldNames[0] = &$this->SQLstmt;
				$count = 1;

				while ($Field = $ResultMeta->fetch_field())
					{
						$FieldNames[$count] =& $ReturnArr[];
						$count++;
					}

				if (call_user_func_array('mysqli_stmt_bind_result', $FieldNames))
					{
						$ResultMeta->close();
						return TRUE;
					} else {
						$ResultMeta->close();
						return FALSE;
					}
			} # end StmtBindArray()


		public function StmtBindAssoc(&$ReturnArr)
			{
				$ResultMeta = $this->SQLstmt->result_metadata();
				if ($ResultMeta == FALSE)
					{
						return FALSE;
					}
				$FieldNames = array();
				$ReturnArr = array();
				$FieldNames[0] = &$this->SQLstmt;
				$count = 1;

				while ($Field = $ResultMeta->fetch_field())
					{
						$FieldNames[$count] =& $ReturnArr[$Field->name];
						$count++;
					}

				if (call_user_func_array('mysqli_stmt_bind_result', $FieldNames))
					{
						$ResultMeta->close();
						return TRUE;
					} else {
						$ResultMeta->close();
						return FALSE;
					}
			} # end StmtBindAssoc()


		public function StmtBindObject(&$ReturnObj)
			{
				$ResultMeta = $this->SQLstmt->result_metadata();
				if ($ResultMeta == FALSE)
					{
						return FALSE;
					}
				$FieldNames = array();
				$ReturnObj = new stdClass;
				$FieldNames[0] = &$this->SQLstmt;
				$count = 1;

				while ($Field = $ResultMeta->fetch_field())
					{
						$fn = $Field->name;
						$FieldNames[$count] =& $ReturnObj->$fn;
						$count++;
					}

				if (call_user_func_array('mysqli_stmt_bind_result', $FieldNames))
					{
						$ResultMeta->close();
						return TRUE;
					} else {
						$ResultMeta->close();
						return FALSE;
					}
			} # end StmtBindObject()


		public function CloseStmt()
			{
				if (!empty($this->SQLstmt))
					{
						$this->SQLstmt->close();
						unset($this->SQLstmt);
					} else {
						$LogData = __FILE__.' '.__METHOD__.'this->SQLstmt is missing.';
						$LogData .= var_export(debug_backtrace(), true);
						$this->Debugging->WriteToLog($LogData);
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__;
						$this->Debugging->WriteToLog($LogData);
					}
			} # end CloseStmt()


		private function RunQuery()
			{
				$returnValue = null;

				if (empty($this->SQL))
					{
						$returnValue = FALSE;
					}

				if ($this->CurrentResult = $this->DB_Con->query($this->SQL))
					{
						$returnValue = $this->CurrentResult;
					} else {
						throw new DBException('Run query failed.');
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' SQL: '.$this->SQL;
						$this->Debugging->WriteToLog($LogData);
					}

				return $returnValue;
			} # end RunQuery()


		public function FetchResults($ReturnFormat = 'assoc', $ReturnArrFormat = 'MYSQLI_NUM')
			{
				if ($this->CurrentResult->num_rows > 0)
					{
						switch ($ReturnFormat) {
							case 'array':
								switch ($ReturnArrFormat) {
									case 'MYSQLI_NUM':
										return $this->CurrentResult->fetch_array(MYSQLI_NUM);
										break;
									case 'MYSQLI_BOTH':
										return $this->CurrentResult->fetch_array(MYSQLI_BOTH);
										break;
									case 'MYSQLI_ASSOC':
									default:
										return $this->CurrentResult->fetch_array(MYSQLI_ASSOC);
										break;
								}
								break;
							case 'object':
								return $this->CurrentResult->fetch_object();
								break;
							case 'assoc':
							default:
								return $this->CurrentResult->fetch_assoc();
								break;
							}
					} else {
						throw new DBException('Fetch results failed.');
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__;
						$this->Debugging->WriteToLog($LogData);
					}

			} # end FetchResults()


		public function CloseResult()
			{
				if ($this->CurrentResult)
					{
						$this->CurrentResult->close();
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__;
						$this->Debugging->WriteToLog($LogData);
					}

			} # end CloseResult()


		public function NumRows()
			{
				$returnValue = null;
				if (isset($this->SQLstmt))
					{
						$returnValue = $this->SQLstmt->num_rows();
					} else {
						$returnValue = $this->CurrentResult->num_rows;
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__;
						$this->Debugging->WriteToLog($LogData);
					}

				return $returnValue;
			} # end NumRows()


		public function AffectedRows()
			{
				$returnValue = null;
				if (isset($this->SQLstmt))
					{
						$returnValue = $this->SQLstmt->affected_rows;
					} else {
						$returnValue = $this->DB_Con->affected_rows;
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__;
						$this->Debugging->WriteToLog($LogData);
					}

			return $returnValue;
			} # end AffectedRows()


		public function Query($QueryType = NULL, $RunAs = 'Standard')
			{
				if (empty($QueryType))
					{
						# throw an exception
					}
				$returnValue = NULL;

				$this->QueryObj->SetSQL($QueryType);
				$this->SQL = $this->QueryObj->GetSQL();

				switch ($QueryType) {
					case 'SELECT':
					case 'SHOW TABLES':
					case 'SHOW COLUMNS':
					case 'DESCRIBE':
					case 'EXPLAIN':
						# these return a result set
						switch ($RunAs) {
							case 'Standard':
								$this->CurrentResult = $this->RunQuery();
								$returnValue = $this->CurrentResult;
								break;
							case 'Prepared':
								$this->SQLstmt =$this->PrepareQuery();
								$returnValue = $this->SQLStmt;
								break;
						}
						break;
					case 'INSERT':
					case 'UPDATE':
					case 'DELETE':
					case 'ALTER TABLE':
					case 'OPTIMIZE TABLE':
					case 'TRUNCATE TABLE':
					case 'CREATE TEMPORARY TABLE':
					case 'DROP TEMPORARY TABLE':
					case 'LOCK TABLES':
					case 'UNLOCK TABLES':
						# these do not return result sets
						switch ($RunAs) {
							case 'Standard':
								$returnValue = $this->RunQuery();
								break;
							case 'Prepared':
								$this->SQLstmt =$this->PrepareQuery();
								$returnValue = $this->SQLStmt;
								break;
						}
						break;
				}

				if ($returnValue == FALSE)
					{
						throw new DBException('Optimize failed.');
					}

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__.' Query type: '.$QueryType.' Run as: '.$RunAs;
						$this->Debugging->WriteToLog($LogData);
					}

				return $returnValue;
			} # end Query()

		public function ShowTables()
			{
				$this->SQL = "\n"
					."SHOW TABLES";

				if ($this->Debug == TRUE)
					{
						$LogData = __FILE__.' '.__METHOD__;
						$this->Debugging->WriteToLog($LogData);
					}

				if ($returnValue == FALSE)
					{
						throw new DBException('Commit failed.');
					}

			} # end ShowTables()

	} /* end of final class MySQL_DB */

?>