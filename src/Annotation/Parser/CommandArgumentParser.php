<?php

namespace Swoft\Console\Bean\Parser;

use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
use Swoft\Annotation\AnnotationException;
use Swoft\Console\Annotation\Mapping\CommandOption;

/**
 * Class CommandMappingParser
 * @since 2.0
 *
 * @AnnotationParser(CommandOption::class)
 */
class CommandOptionParser extends Parser
{
    /**
     * Parse object
     *
     * @param int            $type Class or Method or Property
     * @param CommandOption $annotation Annotation object
     *
     * @return array
     * Return empty array is nothing to do!
     * When class type return [$beanName, $className, $scope, $alias, $size] is to inject bean
     * When property type return [$propertyValue, $isRef] is to reference value
     */
    public function parse(int $type, $annotation): array
    {
        if ($type === self::TYPE_PROPERTY) {
            throw new AnnotationException('`@CommandOption` must be defined on class or method!');
        }

        // add route info for controller action
        CommandParser::addRoute($this->className, [
            'command' => $annotation->getName(),
            'method'  => $this->methodName,
            'alias'   => $annotation->getAlias(),
            'desc'    => $annotation->getDesc(),
        ]);

        return [];
    }
}
