<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\Gallery\Image;

class HashCache
{
    /**
     * @var array
     */
    private array $cache = [];

    /**
     * Retrieve file hash by path
     *
     * @param string $path
     * @return string|null
     */
    public function get(string $path): ?string
    {
        return $this->cache[$path] ?? null;
    }

    /**
     * Set file hash by path
     *
     * @return $this
     */
    public function set(string $path, ?string $hash): self
    {
        $this->cache[$path] = $hash;

        return $this;
    }
}
