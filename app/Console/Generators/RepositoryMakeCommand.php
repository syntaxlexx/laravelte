<?php

namespace App\Console\Generators;

use Str;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:repo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        return class_exists($rawName);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            [
                'DummyNamespace',
                'DummyRootNamespace',
                'NamespacedDummyUserModel',
                'DummyModelTableName',
                'DummySeederClassName',
                'DummyModel',
                'DummyResource',
                'DummyResourceCollection',
            ],
            [
                $this->getNamespace($name),
                $this->rootNamespace(),
                $this->userProviderModel(),
                $this->getDefaultModelTableName($name),
                $this->getSeederNameFromClassName(),
                $this->getModelNameFromClassName(),
                $this->getResourceNameFromClassName(),
                $this->getResourceCollectionNameFromClassName(),
            ],
            $stub
        );

        return $this;
    }

    /**
     * Get model name.
     *
     * @return string
     */
    protected function getModelNameFromClassName()
    {
        return Str::replace('Repository', '', $this->className);
    }

    /**
     * Get resource name.
     *
     * @return string
     */
    protected function getResourceNameFromClassName()
    {
        return $this->getModelNameFromClassName() . 'Resource';
    }

    /**
     * Get resource collection name.
     *
     * @return string
     */
    protected function getResourceCollectionNameFromClassName()
    {
        return $this->getModelNameFromClassName() . 'ResourceCollection';
    }
}
