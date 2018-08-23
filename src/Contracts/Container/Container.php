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
namespace Fire\Contracts\Container;

use Closure;

interface Container
{
    /**
     * Determine if the given abstract type has been bound.
     *
     * @param string $abstract
     * @return bool
     */
    public function bound($abstract);

    /**
     * Alias a type to a different name.
     *
     * @param string $abstract
     * @param string $alias
     * @return void
     */
    public function alias($abstract, $alias);

    /**
     * Assign a set of tags to a given binding.
     *
     * @param array|string $abstracts
     * @param array|mixed  ...$tags
     * @return void
     */
    public function tag($abstracts, $tags);

    /**
     * Resolve all of the bindings for a given tag.
     *
     * @param array $tag
     * @return array
     */
    public function tagged($tag);

    /**
     * Register a binding with the container.
     *
     * @param string|array $abstract
     * @param \Closure|string|null $concrete
     * @param bool $shared
     * @return void
     */
    public function bind($abstract, $concrete = null, $shared = false);

    /**
     * Register a binding if it hasn't already been registered.
     *
     * @param string $abstract
     * @param \Closure|string|null $concrete
     * @param bool $shared
     * @return void
     */
    public function bindIf($abstract, $concrete = null, $shared = false);

    /**
     * Register a shared binding in the container.
     *
     * @param string|array $abstract
     * @param \Closure|string|null $concrete
     * @return void
     */
    public function singleton($abstract, $concrete = null);

    /**
     * "Extend" an abstract type in the container.
     *
     * @param string $abstract
     * @param \Closure $closure
     * @return void
     * @throws \InvalidArgumentException
     */
    public function extend($abstract, Closure $closure);

    /**
     * Register an existing instance as shared in the container.
     *
     * @param string $abstract
     * @param mixed $instance
     * @return void
     */
    public function instance($abstract, $instance);

    /**
     * Define a contextual binding.
     *
     * @param string $concrete
     * @return \Fire\Contracts\Container\ContextualBindingBuilder
     */
    public function when($concrete);

    /**
     * Resolve the given type from the container.
     *
     * @param string $abstract
     * @param array $parameters
     * @return mixed
     */
    public function make($abstract, array $parameters = []);

    /**
     * Call the given Closure / class@method and inject its dependencies.
     *
     * @param callable|string $callback
     * @param array $parameters
     * @param string|null $defaultMethod
     * @return mixed
     */
    public function call($callback, array $parameters = [], $defaultMethod = null);

    /**
     * Determine if the given abstract type has been resolved.
     *
     * @param string $abstract
     * @return bool
     */
    public function resolved($abstract);

    /**
     * Register a new resolving callback.
     *
     * @param string $abstract
     * @param \Closure|null $callback
     * @return void
     */
    public function resolving($abstract, Closure $callback = null);

    /**
     * Register a new after resolving callback.
     *
     * @param string $abstract
     * @param \Closure|null $callback
     * @return void
     */
    public function afterResolving($abstract, Closure $callback = null);
}
