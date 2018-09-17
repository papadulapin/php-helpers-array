<?php

namespace App\Support;

use ArrayAccess;

class Arr
{	
	public static function accessible($array)
	{
		return is_array($array) || $array instanceof ArrayAccess;
	}

	public static function exists($array, $key)
	{
		if ($array instanceof ArrayAccess) {
			return $array->offsetExists($key);
		}

		return array_key_exists($key, $array);
	}

	public static function get($array, $key, $default = null)
	{
		// is array iterable?
		if (!static::accessible($array)) {
			return $default;
		}

		// is key null?
		if (is_null($key)) {
			return $array;
		}

		// if 1st level exists, return
		if (static::exists($array, $key)) {
			return $array[$key];
		}	

		// iterate down and find the value
		foreach (explode('.', $key) as $segment) {
			if (static::accessible($array) && static::exists($array, $segment)) {
				$array = $array[$segment];
			} else {
				return $default;
			}
		}

		return $array; 
	}

	public static function first($array, $callback = null, $default = null)
	{
		if (is_null($callback)) {
			if (empty($array)) {
				return $default;
			}

			foreach ($array as $item) {
				return $item;
			}
		}

		foreach ($array as $key => $value) {
			if (call_user_func($callback, $value, $key)) {
				return $value;
			}
		}


		return $default;
	}

	public static function last($array, $callback = null, $default = null)
	{
		if (is_null($callback)) {
			if (empty($array)) {
				return $default;
			}

			return end($array);
		}

		//rever the array
		//call ::first
		return static::first(array_reverse($array, true), $callback, $default);
	}

	public static function has($array, $key)
	{
		if (is_null($key)) {
			return false;
		}

		$keys = (array) $key;

		if ($keys === []) {
			return false;
		}

		foreach ($keys as $key) {
			$subKeyArray = $array;

			if (static::exists($array, $key)) {
				continue;
			}

			foreach (explode('.', $key) as $segment) {
				if (static::accessible($subKeyArray) && static::exists($subKeyArray, $segment)) {
					$subKeyArray = $subKeyArray[$segment];
				} else {
					return false;
				}
			}

		}		

		return true;
	}

	public static function where($array, $callback)
	{
		return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
	}

	public static function only($array, $key)
	{
		return array_intersect_key($array, array_flip((array) $key));
	}

	public static function forget(&$array, $keys)
	{
		$original = &$array;

		$keys = (array) $keys;

		foreach ($keys as $key) {

			if (static::exists($array, $key)) {
				unset($array[$key]);
				continue;
			}

			$parts = explode('.', $key);

			$array = &$original;

			while(count($parts) > 1) {
				$part = array_shift($parts);

				if (static::accessible($array) && static::exists($array, $part)) {
					$array = &$array[$part];
				} else {
					continue 2;
				}
			}

			unset($array[array_shift($parts)]);
		}
	}
}