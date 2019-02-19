<?php

namespace einfachArchiv\UnpackPdfAttachments;

use Symfony\Component\Process\Process;
use einfachArchiv\UnpackPdfAttachments\Exceptions\PdfNotFound;
use einfachArchiv\UnpackPdfAttachments\Exceptions\UnpackAttachmentsFailed;

class Pdf
{
    /**
     * The path to the PDF.
     *
     * @var string
     */
    protected $path;

    /**
     * The path to the binary.
     *
     * @var string
     */
    protected $binaryPath;

    /**
     * The options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * @param string $binaryPath The path to the binary
     */
    public function __construct(string $binaryPath = null)
    {
        $this->binaryPath = $binaryPath ?? 'pdftk';
    }

    /**
     * Sets the PDF.
     *
     * @return self
     */
    public function setPdf(string $path): self
    {
        if (!is_readable($path)) {
            throw new PdfNotFound(sprintf('Could not find or read PDF `%s`', $path));
        }

        $this->path = $path;

        return $this;
    }

    /**
     * Sets the options.
     *
     * @return self
     */
    public function setOptions(array $options): self
    {
        $mapper = function (string $content): array {
            $content = trim($content);

            return explode(' ', $content, 2);
        };

        $reducer = function (array $carry, array $option): array {
            return array_merge($carry, $option);
        };

        $this->options = array_reduce(array_map($mapper, $options), $reducer, []);

        return $this;
    }

    /**
     * Unpacks the attachments.
     *
     * @return string
     */
    public function unpack(): string
    {
        $process = new Process(array_merge([$this->binaryPath, $this->path, 'unpack_files'], $this->options));

        $process->run();

        if (!$process->isSuccessful()) {
            throw new UnpackAttachmentsFailed($process);
        }

        return trim($process->getOutput(), " \t\n\r\0\x0B\x0C");
    }

    /**
     * Provides a static function.
     *
     * @return string
     */
    public static function unpackAttachments(string $path, array $options = [], string $binaryPath = null): string
    {
        return (new static($binaryPath))
            ->setPdf($path)
            ->setOptions($options)
            ->unpack();
    }
}
