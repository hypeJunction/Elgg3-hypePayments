<?php

namespace hypeJunction\Payments;

trait SerializedMetadata {

	/**
	 * Due to storage length limitations, we need to truncate metadata values
	 * 
	 * @param string $name  Metadata name
	 * @param mixed  $value Metadata value
	 * @return static
	 */
	public function setSerializedMetadata($name, $value = null) {

		$value = serialize($value);
		
		if (strlen($value) > 50000) {
			// Elgg metastring can only hold 65,535 chars
			// Let's explode the string and store as an array
			$this->$name = str_split($value, 50000);
		} else {
			$this->$name = $value;
		}

		return $this;
	}

	/**
	 * Unserialize truncated metadata
	 *
	 * @param string $name Metadata name
	 * @return mixed
	 */
	public function getUnserializedMetadata($name) {
		if (is_array($this->$name)) {
			$serialized = implode('', $this->$name);
			$value = @unserialize($serialized);
		} else {
			$value = @unserialize($this->$name);
		}
		if ($value !== false) {
			return $value;
		}
		return $this->$name;
	}

}
