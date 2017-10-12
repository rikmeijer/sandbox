<?php

stream_wrapper_register('phpi', 'SocketStream');

class SocketStream
{
    /* Properties */
    public $context;

    /* Methods */
    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    public function dir_closedir(): bool
    {

    }

    public function dir_opendir(string $path, int $options): bool
    {

    }

    public function dir_readdir(): string
    {

    }

    public function dir_rewinddir(): bool
    {

    }

    public function mkdir(string $path, int $mode, int $options): bool
    {

    }

    public function rename(string $path_from, string $path_to): bool
    {

    }

    public function rmdir(string $path, int $options): bool
    {

    }

    public function stream_cast(int $cast_as): resource
    {

    }

    public function stream_close(): void
    {

    }

    public function stream_eof(): bool
    {
        return feof($this->context);
    }

    public function stream_flush(): bool
    {

    }

    public function stream_lock(int $operation): bool
    {

    }

    public function stream_metadata(string $path, int $option, mixed $value): bool
    {

    }

    public function stream_open(string $path, string $mode, int $options, string &$opened_path = null): bool
    {
        $this->context = stream_socket_client(str_replace('phpi', 'tcp', $path));
        return true;
    }

    public function stream_read(int $count): string
    {
        return fread($this->context, $count);
    }

    public function stream_seek(int $offset, int $whence = SEEK_SET): bool
    {

    }

    public function stream_set_option(int $option, int $arg1, int $arg2): bool
    {

    }

    public function stream_stat(): array
    {
        return fstat($this->context);
    }

    public function stream_tell(): int
    {

    }

    public function stream_truncate(int $new_size): bool
    {

    }

    public function stream_write(string $data): int
    {

    }

    public function unlink(string $path): bool
    {

    }

    public function url_stat(string $path, int $flags): array
    {

    }
}


include 'phpi://127.0.0.1:8080';