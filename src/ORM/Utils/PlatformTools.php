<?php

namespace App\ORM\Utils;

use App\ORM\Enum\ManagerName;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;
use Throwable;
use Webmozart\Assert\Assert;

use function get_debug_type;
use function sprintf;

final readonly class PlatformTools
{
    public function __construct(
        private ManagerRegistry $registry,
    ) {}

    public function escapeStringForLike(string $value, ManagerName $manager = ManagerName::Default): string
    {
        $em = $this->registry->getManager($manager->value);
        if (!$em instanceof EntityManagerInterface) {
            throw new RuntimeException(
                sprintf('Expected EntityManagerInterface, got %s.', get_debug_type($em)),
            );
        }
        try {
            $platform = $em->getConnection()->getDatabasePlatform();
        } catch (Throwable $e) {
            throw new RuntimeException($e);
        }
        Assert::notNull($platform);
        return $platform->escapeStringForLike($value, '\\');
    }
}
