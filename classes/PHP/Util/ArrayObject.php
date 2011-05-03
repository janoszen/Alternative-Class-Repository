<?php

namespace PHP\Util;

/**
 * This class implements a common array handling for \PHP\Util\Collection and
 * \PHP\Util\Map. No other classes should implement this, because it will most
 * likely not prevail if parts are reimplemented in C.
 *
 * @internal
 */
abstract class ArrayObject implements \Iterator, \ArrayAccess, \Countable, \Serializable {
	/**
	 * Stores the collection elements
	 * @var array
	 */
	protected $data = array();

	/**
	 * Throws a \PHP\Lang\ValueError, if $offset is not of the required type
	 *
	 * @param mixed $offset
	 *
	 * @throws \PHP\Lang\ValueError if $offset is not of the required type
	 */
	abstract protected function keyCheck($offset);

	/**
	 * This function checks, if the ArrayObject subclass may contain the given
	 * type.
	 *
	 * @throws \PHP\Lang\TypeError if the Collection cannot contain this element
	 * 	type.
	 */
	protected function typeCheck($element) {

	}

	/**
	 * Counts the elements in this collection. Implemented as required by the
	 * Countable interface.
	 *
	 * @return int
	 */
	public function count() {
		return count($this->data);
	}

	/**
	 * Returns if an offset exists in this collection. Implemented as required
	 * by the ArrayAccess interface.
	 *
	 * @param int $offset the offset to check
	 *
	 * @return bool
	 *
	 * @throws ValueError of $offset is not an int
	 */
	public function offsetExists($offset) {
		$this->keyCheck($offset);
		if (array_key_exists($offset, $this->data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns an element in this collection. Implemented as required by the
	 * ArrayAccess interface.
	 *
	 * @param int $offset the offset to fetch
	 *
	 * @return mixed
	 *
	 * @throws ValueError of $offset is not an int
	 */
	public function offsetGet($offset) {
		$this->keyCheck($offset);
		if ($this->offsetExists($offset)) {
			return $this->data[$offset];
		} else {
			throw new IndexOutOfBoundsException($offset);
		}
	}

	/**
	 * Set an element in this Collection. Implemented as required by the
	 * ArrayAccess interface.
	 *
	 * @param int|string $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value) {
		$this->typeCheck($value);
		if (\is_null($offset)) {
			$this->data[] = $value;
		} else {
			$this->keyCheck($offset);
			$this->data[$offset] = $value;
		}
	}

	/**
	 * This function unsets a given offset from a Collection. Implemented
	 * as required by the ArrayAccess interface.
	 *
	 * @param int $offset
	 * @return \PHP\Util\Collection
	 * @throws \PHP\Lang\IndexOutOfBoundsException
	 */
	public function offsetUnset($offset) {
		$this->keyCheck($offset);
		if ($this->offsetExists($offset)) {
			unset($this->data[$offset]);
			return $this;
		} else {
			throw new IndexOutOfBoundsException($offset);
		}
	}

	/**
	 * Returns the current element in the Collection. Implemented as required
	 * by the Iterator interface.
	 *
	 * @return mixed
	 * @throws IndexOutOfBoundsException if the current element is not valid
	 */
	public function current() {
		if (!$this->valid()) {
			throw new IndexOutOfBoundsException();
		} else {
			return current($this->data);
		}
	}

	/**
	 * Returns the key of the current element. Returns the key of the current
	 * Collection element. Implemented as required by the Iterator interface.
	 *
	 * @return int|string
	 */
	public function key() {
		return key($this->data);
	}

	/**
	 * Returns the current element and moves the pointer to the next element.
	 * Implemented as required by the Iterator interface.
	 *
	 * @return mixed
	 * @throws IndexOutOfBoundsException if the pointer is at the end of the
	 *  Collection
	 */
	public function next() {
		$current = each($this->data);
		if ($current === false) {
			throw new IndexOutOfBoundsException();
		} else {
			return $current['value'];
		}
	}

	/**
	 * Sets the internal pointer of this collection to the first element.
	 * Implemented as required by the Iterator interface.
	 *
	 * @return bool false if the Collection is empty.
	 */
	public function rewind() {
		if (reset($this->data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks if the Collection internal pointer is on a valid element.
	 * Implemented as required by the Iterator interface.
	 *
	 * @return bool
	 */
	public function valid() {
		if ($this->key() === null) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Serializes this Collection as required by the Serializable interface.
	 *
	 * @return string
	 */
	public function serialize() {
		return serialize($this->data);
	}

	/**
	 * Loads this Collection from a serialized string. Does NOT do a typeCheck.
	 *
	 * @param string $serialized
	 */
	public function unserialize($serialized) {
		$this->data = unserialize($serialized);
	}

	/**
	 * Add a single element
	 *
	 * @param mixed $element
	 *
	 * @return self
	 */
	function add($element) {
		$this->typeCheck($element);
		$this[] = $element;
		return $this;
	}

	/**
	 * Add all elements from an other collection to this one.
	 *
	 * @param self $other
	 *
	 * @return self
	 *
	 * @throws TypeError if an element fails the typeCheck. Returns this
	 *  Collection in a consistent manner.
	 */
	function addAll(self $other) {
		/**
		 * Add a typecheck to return in a consistent manner, if it fails.
		 */
		foreach ($collection as $element) {
			$this->typeCheck($element);
		}
		foreach ($collection as $element) {
			$this[] = $element;
		}
		return $this;
	}

	/**
	 * Deletes all elemens.
	 */
	function clear() {
		$this->data = array();
	}

	/**
	 * Checks if an element is contained here.
	 *
	 * @param mixed $element
	 */
	function contains($element) {
		return in_array($element, $this->data);
	}

	/**
	 * Checks all elements in a Collection if they are contained in this
	 * ArrayObject.
	 *
	 * @param self $other
	 *
	 * @return bool
	 */
	function containsAll(self $other) {
		foreach ($other as $element) {
			if (!$this->contains($elements)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Removes an element by reference.
	 *
	 * @param mixed $element
	 *
	 * @return bool if the data has changed.
	 */
	function remove($element) {
		$key = array_search($element, $this->data);
		if ($key === false) {
			return false;
		} else {
			unset($this->data[$key]);
			return true;
		}
	}

	/**
	 * Remove all elements contained in an other ArrayObject
	 *
	 * @param self $other
	 *
	 * @return self
	 */
	function removeAll(self $other) {
		foreach ($other as $elements) {
			$this->remove($elements);
		}
		return $this;
	}

	/**
	 * Retains all elements contained in a different collection
	 *
	 * @param self $other
	 *
	 * @return self
	 */
	function retainAll(self $other) {
		foreach ($this as $key => $value) {
			if (!$other->contains($value)) {
				unset($this[$key]);
			}
		}
		return $this;
	}
}