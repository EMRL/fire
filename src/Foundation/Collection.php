<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) <Taylor Otwell>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Fire\Foundation;

use Countable;
use ArrayAccess;
use ArrayIterator;
use CachingIterator;
use JsonSerializable;
use IteratorAggregate;
use Fire\Contracts\Foundation\Arrayable;

class Collection implements ArrayAccess, Arrayable, Countable, IteratorAggregate, JsonSerializable
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new collection
     *
     * @param mixed $items
     */
    public function __construct($items = [])
    {
        $items = $this->getArrayableItems($items);

        $this->items = (array) $items;
    }

    /**
     * Create a new collection instance if the value isn't one already.
     *
     * @param mixed $items
     * @return static
     */
    public static function make($items = null)
    {
        return new static($items);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Execute a callback over each item.
     *
     * @param callable $callback
     * @return $this
     */
    public function each(callable $callback)
    {
        array_map($callback, $this->items);

        return $this;
    }

    /**
     * Run a filter over each of the items.
     *
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback)
    {
        return new static(array_filter($this->items, $callback));
    }

    /**
     * Get the first item from the collection.
     *
     * @param callable $callback
     * @param mixed $default
     * @return mixed|null
     */
    public function first()
    {
        return count($this->items) > 0 ? reset($this->items) : null;
    }

    /**
     * Remove an item from the collection by key.
     *
     * @param mixed $key
     * @return void
     */
    public function forget($key)
    {
        $this->offsetUnset($key);
    }

    /**
     * Get an item from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->offsetExists($key)) {
            return $this->items[$key];
        }

        return $default;
    }

    /**
     * Determine if an item exists in the collection by key.
     *
     * @param mixed $key
     * @return bool
     */
    public function has($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Concatenate values of a given key as a string.
     *
     * @param string $glue
     * @return string
     */
    public function implode($glue = null)
    {
        return implode($glue, $this->items);
    }

    /**
     * Determine if the collection is empty or not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Get the keys of the collection items.
     *
     * @return static
     */
    public function keys()
    {
        return new static(array_keys($this->items));
    }

    /**
    * Get the last item from the collection.
    *
    * @return mixed|null
    */
    public function last()
    {
        return count($this->items) > 0 ? end($this->items) : null;
    }

    /**
     * Run a map over each of the items.
     *
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback)
    {
        return new static(array_map($callback, $this->items, array_keys($this->items)));
    }

    /**
     * Merge the collection with the given items.
     *
     * @param Fire\Foundation\Collection|Fire\Contracts\Foundation\Arrayable|array $items
     * @return static
     */
    public function merge($items)
    {
        return new static(array_merge($this->items, $this->getArrayableItems($items)));
    }

    /**
     * "Paginate" the collection by slicing it into a smaller collection.
     *
     * @param int $page
     * @param int $perPage
     * @return static
     */
    public function forPage($page, $perPage)
    {
        return $this->slice(($page - 1) * $perPage, $perPage);
    }

    /**
     * Get and remove the last item from the collection.
     *
     * @return mixed|null
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Push an item onto the beginning of the collection.
     *
     * @param mixed $value
     * @return void
     */
    public function prepend($value)
    {
        array_unshift($this->items, $value);
    }

    /**
     * Push an item onto the end of the collection.
     *
     * @param mixed $value
     * @return void
     */
    public function push($value)
    {
        $this->offsetSet(null, $value);
    }

    /**
     * Put an item in the collection by key.
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function put($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * Get one or more items randomly from the collection.
     *
     * @param int $amount
     * @return mixed
     */
    public function random($amount = 1)
    {
        if ($this->isEmpty())
            return null;

        $keys = array_rand($this->items, $amount);

        return is_array($keys) ? array_intersect_key($this->items, array_flip($keys)) : $this->items[$keys];
    }

    /**
     * Reduce the collection to a single value.
     *
     * @param callable $callback
     * @param mixed $initial
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->items, $callback, $initial);
    }

    /**
     * Create a collection of all elements that do not pass a given truth test.
     *
     * @param callable|mixed $callback
     * @return static
     */
    public function reject($callback)
    {
        if ($this->useAsCallable($callback)) {
            return $this->filter(function ($item) use ($callback) {
                return ! $callback($item);
            });
        }

        return $this->filter(function ($item) use ($callback) {
            return $item != $callback;
        });
    }

    /**
     * Reverse items order.
     *
     * @return static
     */
    public function reverse()
    {
        return new static(array_reverse($this->items));
    }

    /**
     * Search the collection for a given value and return the corresponding key if successful.
     *
     * @param mixed $value
     * @param bool  $strict
     * @return mixed
     */
    public function search($value, $strict = false)
    {
        if ( ! $this->useAsCallable($value)) {
            return array_search($value, $this->items, $strict);
        }

        foreach ($this->items as $key => $item) {
            if ($value($item, $key)) {
                return $key;
            }
        }

        return false;
    }

    /**
     * Get and remove the first item from the collection.
     *
     * @return mixed|null
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Shuffle the items in the collection.
     *
     * @return $this
     */
    public function shuffle()
    {
        shuffle($this->items);
        return $this;
    }

    /**
     * Slice the underlying collection array.
     *
     * @param int $offset
     * @param int $length
     * @param bool $preserveKeys
     * @return static
     */
    public function slice($offset, $length = null, $preserveKeys = false)
    {
        return new static(array_slice($this->items, $offset, $length, $preserveKeys));
    }

    /**
     * Chunk the underlying collection array.
     *
     * @param int $size
     * @param bool $preserveKeys
     * @return static
     */
    public function chunk($size, $preserveKeys = false)
    {
        $chunks = [];

        foreach (array_chunk($this->items, $size, $preserveKeys) as $chunk) {
            $chunks[] = new static($chunk);
        }

        return new static($chunks);
    }

    /**
     * Sort through each item with a callback.
     *
     * @param callable $callback
     * @return $this
     */
    public function sort(callable $callback)
    {
        uasort($this->items, $callback);
        return $this;
    }

    /**
     * Sort the collection using the given callback.
     *
     * @param callable|string $callback
     * @param int $options
     * @param bool $descending
     * @return $this
     */
    public function sortBy($callback, $options = SORT_REGULAR, $descending = false)
    {
        $results = [];

        foreach ($this->items as $key => $value) {
            $results[$key] = $callback($value, $key);
        }

        $descending ? arsort($results, $options) : asort($results, $options);

        foreach (array_keys($results) as $key) {
            $results[$key] = $this->items[$key];
        }

        $this->items = $results;

        return $this;
    }

    /**
     * Sort the collection in descending order using the given callback.
     *
     * @param callable|string $callback
     * @param int $options
     * @return $this
     */
    public function sortByDesc($callback, $options = SORT_REGULAR)
    {
        return $this->sortBy($callback, $options, true);
    }

    /**
     * Splice portion of the underlying collection array.
     *
     * @param int $offset
     * @param int $length
     * @param mixed $replacement
     * @return static
     */
    public function splice($offset, $length = 0, $replacement = [])
    {
        return new static(array_splice($this->items, $offset, $length, $replacement));
    }

    /**
     * Take the first or last {$limit} items.
     *
     * @param int $limit
     * @return static
     */
    public function take($limit = null)
    {
        if ($limit < 0) {
            return $this->slice($limit, abs($limit));
        }

        return $this->slice(0, $limit);
    }

    /**
     * Transform each item in the collection using a callback.
     *
     * @param callable $callback
     * @return $this
     */
    public function transform(callable $callback)
    {
        $this->items = array_map($callback, $this->items);

        return $this;
    }

    /**
     * Return only unique items from the collection array.
     *
     * @return static
     */
    public function unique()
    {
        return new static(array_unique($this->items));
    }

    /**
     * Reset the keys on the underlying array.
     *
     * @return static
     */
    public function values()
    {
        return new static(array_values($this->items));
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, $this->items);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Get the collection of items as JSON.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Get an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Get a CachingIterator instance.
     *
     * @param int $flags
     * @return CachingIterator
     */
    public function getCachingIterator($flags = CachingIterator::CALL_TOSTRING)
    {
        return new CachingIterator($this->getIterator(), $flags);
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get an item at a given offset.
     *
     * @param mixed $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param string $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Determine if the given value is callable, but not a string.
     *
     * @param mixed $value
     * @return bool
     */
    protected function useAsCallable($value)
    {
        return ! (is_string($value) && is_callable($value));
    }

    /**
     * Results array of items from Collection or Arrayable.
     *
     * @param Fire\Foundation\Collection|Fire\Contracts\Foundation\Arrayable|array $items
     * @return array
     */
    protected function getArrayableItems($items)
    {
        if ($items instanceof Collection) {
            $items = $items->all();
        }

        return $items;
    }
}
