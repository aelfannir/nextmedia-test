<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CommandHelper
{
    private $command;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    public function askWithValidation($question, $field, $rules)
    {
        $value = $this->command->ask($question.' '.implode(', ',$rules));

        if($message = $this->validateInput($rules, $field, $value)) {
            $this->command->error($message);
            return $this->askWithValidation($question, $field, $rules);
        }

        return $value;
    }

    public function askForChoice($collection, $question, $multiple = false, $headers = ['id','name'], $rows = ['id','name']) {

        if($collection->count() > 0){

            $this->command->info('== Choices ==');
            $this->command->table(
                $headers,
                array_map(function ($cat) use ($rows){ return Arr::only($cat, $rows); }, $collection->toArray())
            );

            return $this->askForModelChoice($question,$collection, $multiple);
        }

        return null;
    }

    public function askForFile($question, $upload_path)
    {
        $inputPath = $this->command->ask($question);

        if($inputPath){
            if(!file_exists($inputPath)) {
                $this->command->error("File is not exist or it's not readable");
                return $this->askForFile($question, $upload_path);
            }

            return new File($inputPath);
//            $file = new File($inputPath);
//            Storage::putFile($upload_path, $file);
//            return $file->hashName();
        }

        return null;
    }

    public function askForModelChoice($question, $collection, $multiple = false){

        $input = $this->command->ask($question);

        if($multiple){

            $ids = array_unique(explode(',',$input));
            if(count(array_intersect($ids, $collection->pluck('id')->toArray())) !== count($ids)){
                $this->command->error('Invalid ID(s) !');
                return $this->askForModelChoice($question, $collection, true);
            }
            return $ids;

        }else{
            $exists = $collection->contains(function ($_model) use ($input) {
                return $_model->id == $input;
            });

            if(!is_null($input) && !$exists){
                $this->command->error('Invalid ID !');
                return $this->askForModelChoice($question, $collection);
            }

            return $input;
        }


    }

    public function validateInput($rules, $fieldName, $value){
        $validator = Validator::make([$fieldName => $value], [$fieldName => $rules]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
}
