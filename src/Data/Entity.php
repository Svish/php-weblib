<?php
namespace Data;

/**
 * Data entity.
 */
interface Entity
{
	/**
	 * Validates the data.
	 * @throws Error\ValidationFailed If validation failed.
	 */
	public function validate();

	/**
	 * Checks if any data has changed.
	 * @return bool True if any changes; otherwise false.
	 */
	public function is_dirty();

	/**
	 * Saves the entity.
	 * @return bool False if not saved because of no changes; otherwise true.
	 */
	public function save(): bool;

	/**
	 * Gets the entity idenfitied by the given key.
	 * @param mixed ...$keys The key, which can be composite.
	 * @throws Error\NotFound If entity not found.
	 */
	public static function get(...$keys);

	/**
	 * Deletes the enitity idenfitied by the given key.
	 * @param mixed ...$keys The key, which can be composite.
	 * @return bool False if already deleted; otherwise true.
	 */
	public static function delete(...$keys): bool;

	/**
	 * Gets all entities of this type.
	 */
	public static function all(): iterable;
}
