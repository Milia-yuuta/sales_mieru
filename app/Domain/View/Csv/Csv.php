<?php


namespace App\Domain\View\Csv;


abstract class Csv
{
    protected string $delimiter = ',';
    protected string $enclosure = '"';
    protected string $escape = '\\';
    protected string $charset = 'utf8';

    protected string $fileName;
    protected array $header;
    protected array $body;


    public function __construct(array $body)
    {
        $this->body = $body;
    }


    abstract public function getBody(): array;


    public function getDelimiter(): string
    {
        return $this->delimiter;
    }


    public function getEnclosure(): string
    {
        return $this->enclosure;
    }


    public function getEscape(): string
    {
        return $this->escape;
    }


    public function getCharset(): string
    {
        return $this->charset;
    }


    public function getFileName(): string
    {
        return $this->fileName;
    }


    public function getHeader(): array
    {
        return $this->header;
    }

}