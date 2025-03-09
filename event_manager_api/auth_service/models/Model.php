<?php

class Model
{

	public static string $table;
	public static string $primaryKey;
	public static string $cacheName;

	/**
	 * @param array<int,mixed> $fields
	 */
	public function __construct(array $fields) {}

	/**
	 * @param array<string,string> $fields
	 */
	public static function insert(array $fields): array|false|null
	{
		global $conn;

		// Cleaning input

		$keys = [];
		$values = [];

		foreach (array_keys($fields) as $field) {
			$keys[] = str_replace(['"', "'"], '', $field);
		}

		foreach (array_values($fields) as $field) {
			$values[] = str_replace(['"', "'"], '', $field);
		}

		$keys = implode(",", $keys);
		$values = implode("','", $values);
		$tablename = static::$table;

		$sql = "INSERT INTO $tablename ($keys) VALUES ('$values')";

		$success = $conn->query($sql);
		if (!$success) {
			echo $conn->error;
			return null;
		}

		$lastId = $conn->insert_id;

		global $redis;
		if ($redis->get(static::$cacheName) == false) {
			$redis->unlink(static::$cacheName);
		}

		return static::find($lastId);
	}
	/**
	 * @return mixed|<missing>
	 */
	public static function findAll(): array
	{
		global $redis;

		$cachedField = $redis->get(static::$cacheName);
		if ($cachedField) {
			return json_decode($cachedField);
		}

		global $conn;

		$tablename = static::$table;

		$sql = "SELECT * FROM $tablename";

		$results = $conn->query($sql);
		$allResults = $results->fetch_all(MYSQLI_ASSOC);

		$redis->setex(static::$cacheName, 300, json_encode($allResults));

		return $allResults;
	}

	public static function find(string $value): array|false|null
	{

		global $conn;

		$tablename = static::$table;
		$key = static::$primaryKey;

		$sql = "SELECT * FROM $tablename WHERE $key = '$value'";
		$result = $conn->query($sql);

		$row = $result->fetch_assoc();

		return $row;
	}

	public static function findWhere(string $field, string $value, int $limit = 1): array|false|null
	{
		global $conn;

		$tablename = static::$table;

		$sql = "SELECT * FROM $tablename WHERE $field = '$value'";

		$results = $conn->query($sql);

		if ($limit == 1) {
			return $results->fetch_assoc();
		}

		return $results->fetch_all(MYSQLI_ASSOC);
	}

	/**
	 * @param array<string,string> $fields
	 */
	public static function update(string $key, string $value, array $fields): array|false|null
	{

		global $conn;

		$tablename = static::$table;

		$callback = fn(string $k, string $v): string => "$k = \"$v\"";

		$entries = array_map($callback, array_keys($fields), array_values($fields));

		$records = implode(", ", $entries);

		$sql = "UPDATE $tablename SET $records WHERE $key = '$value'";

		$conn->query($sql);

		global $redis;
		if ($redis->get(static::$cacheName) == false) {
			$redis->unlink(static::$cacheName);
		}

		return static::findWhere($key, $value);
	}

	public static function delete(string $field, string $value): void
	{
		global $conn;

		$tablename = static::$table;

		$sql = "DELETE FROM $tablename WHERE $field = '$value'";

		$conn->query($sql);

		global $redis;
		if ($redis->get(static::$cacheName) == false) {
			$redis->unlink(static::$cacheName);
		}
	}
}
