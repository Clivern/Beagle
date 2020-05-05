<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Utils;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

/**
 * Serializer Utils.
 */
class Serializer
{
    /** @var Serializer */
    private $serializer;

    /**
     * Class Constructor.
     */
    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
        $encoders = ['xml' => new XmlEncoder(), 'json' => new JsonEncoder()];
        $normalizers = [new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter)];

        $this->serializer = new SymfonySerializer($normalizers, $encoders);
    }

    /**
     * Serialize Object to Data.
     */
    public function serialize(object $object, string $encoder): string
    {
        return $this->serializer->serialize($object, $encoder);
    }

    /**
     * Deserialize Data to Object.
     */
    public function deserialize(string $data, string $class, string $encoder): object
    {
        return $this->serializer->deserialize($data, $class, $encoder);
    }
}
