<?php

declare(strict_types=1);

namespace App\Domain;

final class CarFactory
{
    /**
     * @param array{engine: array{type: string, code: string, alignment: string, position: string,
     *     size: int, numberOfValves: int, compressionRatio: float, fuel: array{type: string, design: string}},
     *     color: Color, name: string, new: bool} $data
     */
    public static function build(array $data): Car
    {
        return (new Car())
            ->setEngine(self::buildEngine($data['engine']))
            ->setColor($data['color'])
            ->setName($data['name'])
            ->setNew($data['new'])
        ;
    }

    /**
     * @param array{type: string, design: string} $data
     */
    public static function buildFuel(array $data): Fuel
    {
        return (new Fuel())
            ->setType($data['type'])
            ->setDesign($data['design'])
        ;
    }

    /**
     * @param array{type: string, code: string, alignment: string, position: string, size: int, numberOfValves: int,
     *     compressionRatio: float, fuel: array{type: string, design: string}} $data
     */
    public static function buildEngine(array $data): Engine
    {
        return (new Engine())
            ->setType($data['type'])
            ->setCode($data['code'])
            ->setAlignment($data['alignment'])
            ->setPosition($data['position'])
            ->setSize($data['size'])
            ->setNumberOfValves($data['numberOfValves'])
            ->setCompressionRatio($data['compressionRatio'])
            ->setFuel(self::buildFuel($data['fuel']))
        ;
    }
}
