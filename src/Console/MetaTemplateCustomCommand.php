<?php

namespace PyrobyteWeb\MetaTemplates\Console;

use Illuminate\Console\GeneratorCommand;

class MetaTemplateCustomCommand extends GeneratorCommand
{
    protected $signature = 'meta-template:placeholders {name}';
    protected $description = 'Create a new Meta Template class';
    protected $type = 'Query';

    protected function getStub()
    {
        return __DIR__ . '/stubs/meta-template-custom.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\MetaTemplates';
    }

    protected function getNameInput()
    {
        $name = ucwords(str_replace('_', ' ', trim($this->argument('name'))));

        return str_replace(' ', '', $name);
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        return $this->replaceName($stub);
    }

    protected function replaceName(string $stub): string
    {
        $name = lcfirst($this->getNameInput());

        return str_replace(
            'DummyName',
            $name,
            $stub
        );
    }
}
