<?php
declare(strict_types=1);

namespace OurSociety\Console\Process;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Ogr2ogr.
 *
 * This is a wrapper around the `ogr2ogr` binary from the `gdal` package that "Converts simple features data between
 * file formats". We execute this as a background process to import GIS mapping files (such as shapefiles or GeoDB) into
 * MySQL tables of the same name with geometry columns.
 */
class Ogr2ogr
{
    /**
     * @var array
     */
    private $arguments = ['ogr2ogr'];

    public function __construct(string $srcDatasourceName, array $adapterOptions, ?string $query = null)
    {
        $this->setFormat($this->getFormatName($adapterOptions));
        $this->setTransformSrs('EPSG:4326');
        $this->setOverwrite();
        $this->setSql($query);
        $this->setDstDatasourceName($this->getDstDatasourceName($adapterOptions));
        $this->setSrcDatasourceName($srcDatasourceName);
    }

    public function run(): string
    {
        $process = $this->getProcess();
        try {
            $process->mustRun(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    echo 'ERR > '.$buffer;
                } else {
                    echo 'OUT > '.$buffer;
                }
            });

            return $process->getOutput();
        } catch (ProcessFailedException $e) {
            return $e->getMessage();
        }
    }

    private function getDstDatasourceName(array $adapterOptions): string
    {
        if ($adapterOptions['adapter'] !== 'mysql') {
            throw new \RuntimeException('The ogr2ogr wrapper only supports MySQL at current.');
        }

        $optionsList = [
            $adapterOptions['name'],
            'host' => $adapterOptions['host'],
            'user' => $adapterOptions['user'],
            'password' => $adapterOptions['pass'],
            'port' => $adapterOptions['port'],
        ];

        $options = '';
        foreach (array_filter($optionsList) as $key => $value) {
            if (is_numeric($key)) {
                $options .= sprintf('%s,', $value);
            } else {
                $options .= sprintf('%s=%s,', $key, $value);
            }
        }
        $options = rtrim($options, ',');

        return sprintf('%s:%s', 'MYSQL', $options);
    }

    private function getFormatName(array $adapterOptions): string
    {
        if ($adapterOptions['adapter'] !== 'mysql') {
            throw new \RuntimeException('The ogr2ogr wrapper only supports MySQL at current.');
        }

        return 'MySQL';
    }

    private function getProcess(): Process
    {
        $builder = ProcessBuilder::create();
        $builder->setArguments($this->arguments);

        return $builder->getProcess();
    }

    private function setFormat($formatName): void
    {
        $this->arguments[] = '-f';
        $this->arguments[] = $formatName;
    }

    private function setTransformSrs($transformSrs): void
    {
        $this->arguments[] = '-t_srs';
        $this->arguments[] = $transformSrs;
    }

    private function setOverwrite(): void
    {
        $this->arguments[] = '-overwrite';
    }

    private function setSql($sql): void
    {
        $this->arguments[] = '-sql';
        $this->arguments[] = $sql;
    }

    private function setDstDatasourceName($dstDatasourceName): void
    {
        $this->arguments[] = $dstDatasourceName;
    }

    private function setSrcDatasourceName($srcDatasourceName): void
    {
        $this->arguments[] = $srcDatasourceName;
    }

}
