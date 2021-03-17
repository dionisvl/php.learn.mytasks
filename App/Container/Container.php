<?php


namespace App\Container;


use App\Container\Exception\ContainerException;
use App\Container\Exception\ParameterNotFoundException;
use App\Container\Exception\ServiceNotFoundException;
use App\Container\Reference\ParameterReference;
use App\Container\Reference\ServiceReference;
use Interop\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private $services;
    private $parameters;
    private $serviceStore;

    public function __construct(array $services = [], array $parameters = [])
    {
        $this->services = $services;
        $this->parameters = $parameters;
        $this->serviceStore = [];
    }

    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new ServiceNotFoundException('Service not found: ' . $id);
        }

        if (!isset($this->serviceStore[$id])) {
            $this->serviceStore[$id] = $this->createService($id);
        }

        return $this->serviceStore[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }

    public function getParameter($id)
    {
        $tokens = explode('.', $id);
        $context = $this->parameters;

        while (null !== ($token = array_shift($tokens))) {
            if (!isset($context[$token])) {
                throw new ParameterNotFoundException('Parameter not found: ' . $id);
            }

            $context = $context[$token];
        }

        return $context;
    }

    private function createService($name)
    {
        $entry = &$this->services[$name];

        if (!is_array($entry) || !isset($entry['class'])) {
            throw new ContainerException($name . ' service entry must be an array containing a \'class\' key');
        }

        if (!class_exists($entry['class'])) {
            throw new ContainerException($name . ' service class does not exist: ' . $entry['class']);
        }

        if (isset($entry['lock'])) {
            throw new ContainerException($name . ' service contains a circular reference');
        }

        $entry['lock'] = true;

        $arguments = isset($entry['arguments']) ? $this->resolveArguments($name, $entry['arguments']) : [];

        try {
            $reflector = new \ReflectionClass($entry['class']);
            $service = $reflector->newInstanceArgs($arguments);
        } catch (\ReflectionException $e) {
        }


        if (isset($entry['calls'])) {
            $this->initializeService($service, $name, $entry['calls']);
        }

        return $service;
    }

    private function resolveArguments($name, array $argumentDefinitions): array
    {
        $arguments = [];

        foreach ($argumentDefinitions as $argumentDefinition) {
            if ($argumentDefinition instanceof ServiceReference) {
                $argumentServiceName = $argumentDefinition->getName();

                $arguments[] = $this->get($argumentServiceName);
            } elseif ($argumentDefinition instanceof ParameterReference) {
                $argumentParameterName = $argumentDefinition->getName();

                $arguments[] = $this->getParameter($argumentParameterName);
            } else {
                $arguments[] = $argumentDefinition;
            }
        }

        return $arguments;
    }

    private function initializeService($service, $name, array $callDefinitions): void
    {
        foreach ($callDefinitions as $callDefinition) {
            if (!is_array($callDefinition) || !isset($callDefinition['method'])) {
                throw new ContainerException($name . ' service calls must be arrays containing a \'method\' key');
            }

            if (!is_callable([$service, $callDefinition['method']])) {
                throw new ContainerException(
                    $name . ' service asks for call to uncallable method: ' . $callDefinition['method']
                );
            }

            $arguments = isset($callDefinition['arguments']) ? $this->resolveArguments(
                $name,
                $callDefinition['arguments']
            ) : [];

            call_user_func_array([$service, $callDefinition['method']], $arguments);
        }
    }

}