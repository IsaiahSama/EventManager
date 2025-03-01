<?php

class Model
{

	protected $table;
	protected $primaryKey;

	public static function insert(array $fields): void
	{
		global $conn;

		$keys = implode(",", array_keys($fields));
		$values = implode("','", array_values($fields));
		$tablename = static::$table;

		$sql = "INSERT INTO $tablename ($keys) VALUES ($values)";

		$conn->query($sql);
	}

	public static function find($value): array|false|null
	{

		global $conn;

		$tablename = static::$table;
		$key = static::$primaryKey;

		$sql = "SELECT * FROM $tablename WHERE $key = $value";
		$result = $conn->query($sql);

		$row = $result->fetch_assoc();

		return $row;
	}

	public static function update($key, $value, array $fields): void
	{

		global $conn;

		$tablename = static::$table;

		$callback = fn(string $k, string $v): string => "$k TO $v";

		$entries = array_map($callback, array_keys($fields), array_values($fields));

		$records = implode(",", $entries);

		$sql = "UPDATE $tablename SET ($records) WHERE $key = $value";

		$conn->query($sql);
	}

	public static function delete(string $field, string $value): void
	{
		global $conn;

		$tablename = static::$table;

		$sql = "DELETE FROM $tablename WHERE $field = $value";

		$conn->query($sql);
	}
}
