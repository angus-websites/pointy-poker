<?php

namespace App\Services;

use App\Contracts\Repository\CodeRepositoryInterface;
use App\Exceptions\CodeGeneratorException;
use Illuminate\Support\Facades\Log;
use Random\RandomException;

/**
 * Service for generating unique codes
 *
 * it requires a repository that can check for existing codes
 * i.e. one that conforms to CodeRepositoryInterface
 */
class CodeGeneratorService
{
    protected string $characterSet;

    public function __construct(
        protected CodeRepositoryInterface $repo,
        protected int $initialLength = 6,
        protected int $maxLength = 10,
        protected int $attemptsPerLength = 100
    ) {
        $this->characterSet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    }

    /**
     * Generate a unique code
     * if a unique code cannot be found within the constraints,
     * an exception is thrown
     *
     * @return string The unique code
     *
     * @throws CodeGeneratorException
     */
    public function generate(): string
    {
        $length = $this->initialLength;

        while ($length <= $this->maxLength) {
            for ($i = 0; $i < $this->attemptsPerLength; $i++) {
                try {
                    $code = $this->code($length);

                } catch (RandomException) {
                    Log::error('Random code generation failed');
                }

                if (! $this->repo->findByCode($code)) {
                    return $code;
                }
            }

            $length++;
        }

        throw new CodeGeneratorException('Unable to generate a unique code');
    }

    /**
     * @throws RandomException
     */
    private function code(int $length): string
    {
        // Generate a random code of the specified length using the character set
        $code = '';
        $endIndex = strlen($this->characterSet) - 1;
        for ($j = 0; $j < $length; $j++) {
            $code .= $this->characterSet[random_int(0, $endIndex - 1)];
        }

        return $code;

    }
}
