<?php

namespace PyrobyteWeb\MetaTemplates\Console;

use Illuminate\Database\Console\Migrations\BaseCommand;
use Illuminate\Database\Console\Migrations\TableGuesser;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;
use PyrobyteWeb\MetaTemplates\Database\Migrations\MetaTemplateCreator;

class MetaTemplateAddCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meta-template:add {name : name meta template} {--fullpath : Output the full path of the migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The migration creator instance.
     *
     * @var MetaTemplateCreator
     */
    protected $creator;

    /**
     * The Composer instance.
     *
     * @var Composer
     */
    protected $composer;

    /**
     * Create a new migration install command instance.
     *
     * @param MetaTemplateCreator $creator
     * @param Composer $composer
     * @return void
     */
    public function __construct(MetaTemplateCreator $creator, Composer $composer)
    {
        parent::__construct();

        $this->creator = $creator;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = Str::snake(trim('add_meta_template_').$this->input->getArgument('name'));
        [$table, $create] = TableGuesser::guess($name);

        $this->writeMigration($name, $table, $create);

        $this->composer->dumpAutoloads();
    }

    protected function writeMigration($name, $table, $create)
    {
        $file = $this->creator->create(
            $name, $this->getMigrationPath(), $table, $create
        );

        if (! $this->option('fullpath')) {
            $file = pathinfo($file, PATHINFO_FILENAME);
        }

        $this->call(MetaTemplateCustomCommand::class, [
            'name' => $this->input->getArgument('name')
        ]);

        $this->line("<info>Created Migration:</info> {$file}");
    }
}
