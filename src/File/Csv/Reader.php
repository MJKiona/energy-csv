<?php

declare(strict_types=1);

namespace Kiona\File\Csv;

use Assert\Assertion;
use Generator;
use SplFileObject;

final class Reader
{
    private const FILE_DOES_NOT_EXISTS = 'File "%s" does not exists.';
    private const SEPARATOR = ';';

    public function getRows(string $fileName) : Generator
    {
        Assertion::file($fileName, sprintf(self::FILE_DOES_NOT_EXISTS, $fileName));

        $file = new SplFileObject($fileName);

        $file->setCsvControl(self::SEPARATOR);
        $file->setFlags($this->getFlags());

        $rowNumber = 0;
        while (!$file->eof()) {
            $rowNumber++;
            $row = $file->fgetcsv();
            if ($row !== false) {
                yield [$rowNumber => $row];
            }
        }
    }

    private function getFlags() : int
    {
        return SplFileObject::READ_AHEAD
            | SplFileObject::DROP_NEW_LINE
            | SplFileObject::SKIP_EMPTY
            | SplFileObject::READ_CSV;
    }
}
