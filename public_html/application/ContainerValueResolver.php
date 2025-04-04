<?php
namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ContainerValueResolver implements ValueResolverInterface
{
    public function __construct(private Container $container) {}

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return array
     */
    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        $result = [];
        $type = $argument->getType();
        if ($type && (class_exists($type) || interface_exists($type))) {
            if (!$argument->isVariadic() && $request->attributes->has($argument->getName())) {
                $result = [$this->container->get($type), $request->attributes->get($argument->getName())];
            } else {
                $result = [$this->container->get($type)];
            }
        } else {
            $result = !$argument->isVariadic() && $request->attributes->has($argument->getName()) ? [$request->attributes->get($argument->getName())] : [];
        }

        return $result;
    }
}