<?php

declare(strict_types=1);

namespace Doctrine\Persistence;

/**
 * Interface for proxy classes.
 *
 * @template T of object
 */
interface Proxy
{
    /**
     * Marker for Proxy class names.
     */
    public const MARKER = '__CG__';

    /**
     * Length of the proxy marker.
     */
    public const MARKER_LENGTH = 6;

    /**
     * Initializes this proxy if its not yet initialized.
     *
     * Acts as a no-op if already initialized.
     */
    public function __load(): void;

    /** Returns whether this proxy is initialized or not. */
    public function __isInitialized(): bool;
}
