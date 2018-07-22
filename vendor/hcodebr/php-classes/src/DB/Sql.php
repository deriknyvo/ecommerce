<?php

namespace Hcode\DB;

class Sql
{
	const HOSTNAME = '127.0.0.1';
	const USERNAME = 'root';
	const PASSWORD = '';
	const DBNAME = 'db_ecommerce';
	const DSN = 'mysql:host='.Sql::HOSTNAME.';dbname='.Sql::DBNAME;

	private $conn;

	public function __construct()
	{
		$this->conn = new \PDO(Sql::DSN, Sql::USERNAME, Sql::PASSWORD);
	}

	private function setParams($statement, $parameters = [])
	{
		foreach ($parameters as $key => $value) {
			$this->bindParam($statement, $key, $value);
		}
	}

	private function bindParam($statement, $key, $value)
	{
		$statement->bindParam($key, $value);
	}

	public function query($rawQuery, $params = [])
	{
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);
		$stmt->execute();
	}

	public function select($rawQuery, $params = []):array
	{
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}
