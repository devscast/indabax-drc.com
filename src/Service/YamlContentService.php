<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * class YamlContentService.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class YamlContentService
{
    public function __construct(
        private readonly ContainerBagInterface $container,
        private readonly CacheInterface $cache,
        private readonly KernelInterface $kernel
    ) {
    }

    public function get(string $key): mixed
    {
        $data = strval($this->container->get($key));
        if ($this->kernel->getEnvironment() === 'dev') {
            return Yaml::parseFile($data);
        }

        return $this->cache->get($key, fn () => Yaml::parseFile($data));
    }
}
