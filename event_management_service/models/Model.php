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

		$keys = implode(",", array_keys($fields));
		$values = implode("','", array_values($fields));
		$tablename = static::$table;

		$sql = "INSERT INTO $tablename ($keys) VALUES ('$values')";

		$conn->query($sql);

		$lastId = $conn->insert_id;

		return static::find($lastId);
	}

	public static function findAll(): array
	{
		$redis = new Redis();
		$redis->connect('redis', 6379);

		$cachedField = $redis->get(static::$cacheName);
		if ($cachedField) {
			return json_decode($cachedField);
		}

		global $conn;

		$tablename = static::$table;

		$sql = "SELECT * FROM $tablename";

		$results = $conn->query($sql);
		$allResults = $results->fetch_all(MYSQLI_ASSOC);

		$redis->setex(static::$cacheName, 10, json_encode($allResults));

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

		return static::findWhere($key, $value);
	}

	public static function delete(string $field, string $value): void
	{
		global $conn;

		$tablename = static::$table;

		$sql = "DELETE FROM $tablename WHERE $field = '$value'";

		$conn->query($sql);
	}
}
