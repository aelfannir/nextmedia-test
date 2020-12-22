<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\File;

/**
 * Class AppCommand
 * @package App\Console\Commands
 */
class AppCommand extends Command
{
    /**
     * @var string
     */
    protected $name = 'command';

    /**
     * @param $question
     * @param $collection
     * @param bool $multiple
     * @param string[] $headers
     * @return false|mixed|string[]|null
     */
    public function askForChoice($question, $collection, $multiple = false, $headers = ['Id', 'Name'])
    {
        if ($collection->count() > 0) {
            $this->info('== List of ID\'s ==');
            $this->table($headers, $collection);

            return $this->askForModelChoice($question, $collection, $multiple);
        }

        return null;
    }

    /**
     * @param string $question
     * @param string $upload_path
     * @return File|null
     */
    public function askForFile($question, $upload_path): ?File
    {
        $input_path = $this->ask($question.' path');
        if ($input_path) {
            if (!file_exists($input_path)) {
                $this->error("File is not exist or it's not readable");

                return $this->askForFile($question, $upload_path);
            }

            return new File($input_path);
        }

        return null;
    }

    /**
     * @param $question
     * @param $collection
     * @param false $multiple
     * @return false|mixed|string[]
     */
    public function askForModelChoice($question, $collection, $multiple = false)
    {
        $input = $this->ask($question);

        if (is_null($input)) {
            return $multiple ? [] : null;
        }

        $ids = $collection->pluck('id')->toArray();
        if ($multiple) {
            $input = array_unique(explode(',',$input));

            if (! empty(array_diff($input, $ids))) {
                $this->error('Invalid ID(s) !');

                return $this->askForModelChoice($question, $collection, true);
            }

        } elseif (! in_array($input, $ids)) {
            $this->error('Invalid ID !');

            return $this->askForModelChoice($question, $collection);
        }

        return $input;
    }
}
